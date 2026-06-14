<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Gunung;
use App\Models\AnggotaPendaftaran;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendakiController extends Controller
{
    public function dashboard()
    {
        $pendaftaran = Auth::user()->pendaftaran()->with('gunung')->orderBy('created_at', 'desc')->get();
        return view('pendaki.dashboard', compact('pendaftaran'));
    }

    public function createPendaftaran()
    {
        $gunung = Gunung::all();
        return view('pendaki.pendaftaran.create', compact('gunung'));
    }

    public function storePendaftaran(Request $request)
    {
        $data = $request->validate([
            'gunung_id' => 'required|exists:gunung,id',
            'nama_ketua' => 'required|string|max:255',
            'tanggal_pendakian' => 'required|date|after:today',
            'jumlah_anggota' => 'required|integer|min:1|max:10',
            'jenis_pendakian' => 'required|string|in:camp,tektok',
            'dokumen_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'dokumen_sehat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'anggota' => 'required|array|min:1',
            'anggota.*.nama' => 'required|string|max:255',
            'anggota.*.no_ktp' => 'required|string|max:20',
            'anggota.*.usia' => 'required|integer|min:5',
            'anggota.*.no_hp' => 'required|string|max:15',
        ]);

        // Cek Blacklist
        foreach ($data['anggota'] as $index => $anggota) {
            $isBlacklisted = \App\Models\Blacklist::where('no_ktp', $anggota['no_ktp'])->first();
            if ($isBlacklisted) {
                $roleName = ($index == 0) ? 'Ketua Kelompok' : 'Anggota ' . ($index + 1);
                return back()->withErrors([
                    'anggota' => "Pendaftaran ditolak karena {$roleName} ({$anggota['nama']}) dengan NIK {$anggota['no_ktp']} masuk dalam Daftar Hitam (Blacklist). Alasan: {$isBlacklisted->alasan}"
                ])->withInput();
            }
        }

        $gunung = Gunung::findOrFail($data['gunung_id']);
        $terisi = Pendaftaran::where('gunung_id', $data['gunung_id'])
            ->where('tanggal_pendakian', $data['tanggal_pendakian'])
            ->where('status_verifikasi', 'disetujui')
            ->sum('jumlah_anggota');
        if (($terisi + $data['jumlah_anggota']) > $gunung->kuota_maks) {
            return back()->withErrors(['tanggal_pendakian' => 'Kuota untuk tanggal ini sudah penuh!']);
        }

        $harga_per_orang = $data['jenis_pendakian'] == 'tektok' 
            ? $gunung->harga_per_orang_tektok 
            : $gunung->harga_per_orang;
        $data['user_id'] = Auth::id();
        $data['id_booking'] = 'PEND-' . strtoupper(uniqid());
        $data['status_verifikasi'] = 'pending';
        $data['status_pembayaran'] = 'pending';
        $data['total_harga'] = $harga_per_orang * $data['jumlah_anggota'];
        $data['dokumen_ktp'] = $request->file('dokumen_ktp')->store('dokumen', 'local');
        $data['dokumen_sehat'] = $request->file('dokumen_sehat')->store('dokumen', 'local');

        $pendaftaran = Pendaftaran::create($data);

        foreach ($data['anggota'] as $anggota) {
            AnggotaPendaftaran::create([
                'pendaftaran_id' => $pendaftaran->id,
                'nama' => $anggota['nama'],
                'no_ktp' => $anggota['no_ktp'],
                'usia' => $anggota['usia'],
                'no_hp' => $anggota['no_hp'],
            ]);
        }

        return redirect()->route('pendaki.pendaftaran.show', $pendaftaran->id)->with('success', 'Pendaftaran berhasil dibuat!');
    }

    public function createPayment($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        if ($pendaftaran->user_id !== Auth::id()) {
            abort(403);
        }

        if (!class_exists('Midtrans\Config')) {
            return back()->with('error', 'Package Midtrans belum terinstall! Silakan jalankan: composer require midtrans/midtrans-php');
        }

        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

        $order_id = $pendaftaran->id_booking . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $pendaftaran->total_harga,
            ],
            'customer_details' => [
                'first_name' => $pendaftaran->nama_ketua,
                'email' => Auth::user()->email,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        Payment::create([
            'pendaftaran_id' => $pendaftaran->id,
            'order_id' => $order_id,
            'transaction_status' => 'pending',
            'gross_amount' => $pendaftaran->total_harga,
        ]);

        return view('pendaki.pendaftaran.payment', compact('pendaftaran', 'snapToken'));
    }

    public function paymentSuccess($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        if ($pendaftaran->user_id !== Auth::id()) {
            abort(403);
        }
        return redirect()->route('pendaki.pendaftaran.show', $pendaftaran->id)->with('success', 'Pembayaran berhasil!');
    }

    public function paymentCallback(Request $request)
    {
        if (!class_exists('Midtrans\Notification')) {
            return response()->json(['status' => 'error', 'message' => 'Midtrans not installed'], 500);
        }

        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        
        $notification = new \Midtrans\Notification();
        $transaction = $notification->transaction_status;
        $order_id = $notification->order_id;

        $payment = Payment::where('order_id', $order_id)->firstOrFail();
        $pendaftaran = $payment->pendaftaran;

        $this->updatePaymentStatus($payment, $pendaftaran, $transaction, $notification);

        return response()->json(['status' => 'success']);
    }

    public function checkPaymentStatus($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        if ($pendaftaran->user_id !== Auth::id()) {
            abort(403);
        }

        if (!class_exists('Midtrans\Transaction')) {
            return back()->with('error', 'Package Midtrans belum terinstall!');
        }

        $payment = $pendaftaran->payments()->latest()->first();
        if (!$payment) {
            return back()->with('error', 'Belum ada transaksi pembayaran!');
        }

        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');

        try {
            $status = \Midtrans\Transaction::status($payment->order_id);
            $transaction = $status->transaction_status;
            $this->updatePaymentStatus($payment, $pendaftaran, $transaction, $status);
            
            return back()->with('success', 'Status pembayaran berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memeriksa status pembayaran: ' . $e->getMessage());
        }
    }

    private function updatePaymentStatus($payment, $pendaftaran, $transaction, $notification)
    {
        if ($transaction == 'capture') {
            if ($notification->fraud_status == 'accept') {
                $payment->update([
                    'transaction_id' => $notification->transaction_id,
                    'payment_type' => $notification->payment_type,
                    'transaction_status' => 'settlement',
                    'transaction_time' => now(),
                ]);
                $pendaftaran->update(['status_pembayaran' => 'paid']);
            }
        } elseif ($transaction == 'settlement') {
            $payment->update([
                'transaction_id' => $notification->transaction_id,
                'payment_type' => $notification->payment_type,
                'transaction_status' => 'settlement',
                'transaction_time' => now(),
            ]);
            $pendaftaran->update(['status_pembayaran' => 'paid']);
        } elseif ($transaction == 'pending') {
            $payment->update([
                'transaction_id' => $notification->transaction_id,
                'payment_type' => $notification->payment_type,
                'transaction_status' => 'pending',
                'payment_code' => $notification->payment_code ?? null,
                'transaction_time' => now(),
            ]);
        } elseif ($transaction == 'deny') {
            $payment->update([
                'transaction_id' => $notification->transaction_id,
                'payment_type' => $notification->payment_type,
                'transaction_status' => 'deny',
                'transaction_time' => now(),
            ]);
            $pendaftaran->update(['status_pembayaran' => 'failed']);
        } elseif ($transaction == 'expire') {
            $payment->update([
                'transaction_id' => $notification->transaction_id,
                'payment_type' => $notification->payment_type,
                'transaction_status' => 'expire',
                'transaction_time' => now(),
            ]);
            $pendaftaran->update(['status_pembayaran' => 'expired']);
        } elseif ($transaction == 'cancel') {
            $payment->update([
                'transaction_id' => $notification->transaction_id,
                'payment_type' => $notification->payment_type,
                'transaction_status' => 'cancel',
                'transaction_time' => now(),
            ]);
            $pendaftaran->update(['status_pembayaran' => 'failed']);
        }
    }

    public function showPendaftaran($id)
    {
        $pendaftaran = Pendaftaran::with('user', 'gunung', 'anggota')->findOrFail($id);
        if ($pendaftaran->user_id !== Auth::id()) {
            abort(403);
        }
        return view('pendaki.pendaftaran.show', compact('pendaftaran'));
    }

    public function editPendaftaran($id)
    {
        $pendaftaran = Pendaftaran::with('anggota')->findOrFail($id);
        if ($pendaftaran->user_id !== Auth::id() || $pendaftaran->status_verifikasi !== 'pending' || $pendaftaran->status_pembayaran == 'paid') {
            abort(403);
        }
        $gunung = Gunung::all();
        return view('pendaki.pendaftaran.edit', compact('pendaftaran', 'gunung'));
    }

    public function updatePendaftaran(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        if ($pendaftaran->user_id !== Auth::id() || $pendaftaran->status_verifikasi !== 'pending' || $pendaftaran->status_pembayaran == 'paid') {
            abort(403);
        }

        $data = $request->validate([
            'gunung_id' => 'required|exists:gunung,id',
            'nama_ketua' => 'required|string|max:255',
            'tanggal_pendakian' => 'required|date|after:today',
            'jumlah_anggota' => 'required|integer|min:1|max:10',
            'jenis_pendakian' => 'required|string|in:camp,tektok',
            'dokumen_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'dokumen_sehat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'anggota' => 'required|array|min:1',
            'anggota.*.nama' => 'required|string|max:255',
            'anggota.*.no_ktp' => 'required|string|max:20',
            'anggota.*.usia' => 'required|integer|min:5',
            'anggota.*.no_hp' => 'required|string|max:15',
        ]);

        // Cek Blacklist
        foreach ($data['anggota'] as $index => $anggota) {
            $isBlacklisted = \App\Models\Blacklist::where('no_ktp', $anggota['no_ktp'])->first();
            if ($isBlacklisted) {
                $roleName = ($index == 0) ? 'Ketua Kelompok' : 'Anggota ' . ($index + 1);
                return back()->withErrors([
                    'anggota' => "Pendaftaran ditolak karena {$roleName} ({$anggota['nama']}) dengan NIK {$anggota['no_ktp']} masuk dalam Daftar Hitam (Blacklist). Alasan: {$isBlacklisted->alasan}"
                ])->withInput();
            }
        }

        if ($request->hasFile('dokumen_ktp')) {
            Storage::disk('local')->delete($pendaftaran->dokumen_ktp);
            $data['dokumen_ktp'] = $request->file('dokumen_ktp')->store('dokumen', 'local');
        }
        if ($request->hasFile('dokumen_sehat')) {
            Storage::disk('local')->delete($pendaftaran->dokumen_sehat);
            $data['dokumen_sehat'] = $request->file('dokumen_sehat')->store('dokumen', 'local');
        }

        $gunung = Gunung::findOrFail($data['gunung_id']);
        $harga_per_orang = $data['jenis_pendakian'] == 'tektok' 
            ? $gunung->harga_per_orang_tektok 
            : $gunung->harga_per_orang;
        $data['total_harga'] = $harga_per_orang * $data['jumlah_anggota'];

        $pendaftaran->update($data);

        AnggotaPendaftaran::where('pendaftaran_id', $pendaftaran->id)->delete();
        foreach ($data['anggota'] as $anggota) {
            AnggotaPendaftaran::create([
                'pendaftaran_id' => $pendaftaran->id,
                'nama' => $anggota['nama'],
                'no_ktp' => $anggota['no_ktp'],
                'usia' => $anggota['usia'],
                'no_hp' => $anggota['no_hp'],
            ]);
        }

        return redirect()->route('pendaki.pendaftaran.show', $pendaftaran->id)->with('success', 'Pendaftaran berhasil diperbarui!');
    }

    public function cancelPendaftaran($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        if ($pendaftaran->user_id !== Auth::id() || $pendaftaran->status_verifikasi !== 'pending') {
            abort(403);
        }
        $pendaftaran->delete();
        return redirect()->route('pendaki.dashboard')->with('success', 'Pendaftaran berhasil dibatalkan!');
    }

    public function cetakPendaftaran($id)
    {
        $pendaftaran = Pendaftaran::with('user', 'gunung', 'anggota')->findOrFail($id);
        if ($pendaftaran->user_id !== Auth::id()) {
            abort(403);
        }
        return view('pendaki.pendaftaran.cetak', compact('pendaftaran'));
    }

    public function cekKuota(Request $request)
    {
        $gunung = Gunung::findOrFail($request->gunung_id);
        $terisi = Pendaftaran::where('gunung_id', $request->gunung_id)
            ->where('tanggal_pendakian', $request->tanggal)
            ->where('status_verifikasi', 'disetujui')
            ->sum('jumlah_anggota');
        $sisa = $gunung->kuota_maks - $terisi;
        return response()->json(['sisa' => $sisa, 'max' => $gunung->kuota_maks]);
    }

    public function notifications()
    {
        $notifications = Auth::user()->notifications()->orderBy('created_at', 'desc')->get();
        return view('pendaki.notifications', compact('notifications'));
    }

    public function readAllNotifications()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi ditandai sebagai terbaca.');
    }
}
