<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Gunung;
use App\Models\LogAdmin;
use App\Models\Blacklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendaftaran = Pendaftaran::with('user', 'gunung')->orderBy('created_at', 'desc')->get();
        $total = $pendaftaran->count();
        $pending = $pendaftaran->where('status_verifikasi', 'pending')->count();
        $disetujui = $pendaftaran->where('status_verifikasi', 'disetujui')->count();
        $ditolak = $pendaftaran->where('status_verifikasi', 'ditolak')->count();
        $sedang_mendaki = Pendaftaran::where('status_pendakian', 'sedang_mendaki')->count();
        $total_blacklist = Blacklist::count();
        $total_pendapatan = Pendaftaran::where('status_pembayaran', 'paid')->sum('total_harga');

        // Data grafik: pendaftaran per bulan (12 bulan terakhir)
        $pendaftaranBulanan = Pendaftaran::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('YEAR(created_at) as tahun'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')->orderBy('bulan')
            ->get();

        $labelBulan = [];
        $dataBulan = [];
        foreach ($pendaftaranBulanan as $row) {
            $bulanNames = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            $labelBulan[] = $bulanNames[$row->bulan] . ' ' . $row->tahun;
            $dataBulan[] = $row->total;
        }

        // Data grafik: gunung terfavorit
        $gunungFavorit = Pendaftaran::select('gunung_id', DB::raw('COUNT(*) as total'))
            ->with('gunung')
            ->where('status_verifikasi', 'disetujui')
            ->groupBy('gunung_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $labelGunung = $gunungFavorit->map(fn($p) => $p->gunung ? $p->gunung->nama_gunung . ' (' . $p->gunung->jalur . ')' : 'Unknown')->toArray();
        $dataGunung = $gunungFavorit->pluck('total')->toArray();

        return view('admin.dashboard', compact(
            'pendaftaran', 'total', 'pending', 'disetujui', 'ditolak',
            'sedang_mendaki', 'total_blacklist', 'total_pendapatan',
            'labelBulan', 'dataBulan', 'labelGunung', 'dataGunung'
        ));
    }

    public function manifes(Request $request)
    {
        $gunung = Gunung::all();
        $pendaftaran = collect();
        $filterGunung = null;
        $filterTanggal = null;

        if ($request->has('tanggal') && $request->has('gunung_id')) {
            $filterTanggal = $request->tanggal;
            $filterGunung = $request->gunung_id;
            $pendaftaran = Pendaftaran::with('user', 'gunung', 'anggota')
                ->where('tanggal_pendakian', $filterTanggal)
                ->where('gunung_id', $filterGunung)
                ->where('status_verifikasi', 'disetujui')
                ->get();
        }

        return view('admin.manifes.index', compact('gunung', 'pendaftaran', 'filterTanggal', 'filterGunung'));
    }

    public function showPendaftaran($id)
    {
        $pendaftaran = Pendaftaran::with('user', 'gunung', 'anggota')->findOrFail($id);
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'status_verifikasi' => $request->status,
            'alasan_penolakan' => $request->alasan,
            'tanggal_verifikasi' => now(),
        ]);

        LogAdmin::create([
            'admin_id' => Auth::id(),
            'pendaftaran_id' => $pendaftaran->id,
            'aksi' => $request->status,
            'keterangan' => $request->alasan ?? 'Status diperbarui',
        ]);

        // Kirim Notifikasi
        $pendaftaran->user->notify(new \App\Notifications\PendaftaranStatusChanged($pendaftaran, $request->status));

        return back()->with('success', 'Status pendaftaran berhasil diperbarui!');
    }

    public function checkIn($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        if ($pendaftaran->status_verifikasi !== 'disetujui' || $pendaftaran->status_pembayaran !== 'paid') {
            return back()->withErrors(['error' => 'Pendaftaran harus disetujui dan lunas sebelum Check-In.']);
        }

        if ($pendaftaran->status_pendakian !== 'belum_mendaki') {
            return back()->withErrors(['error' => 'Status pendakian tidak valid untuk Check-In.']);
        }

        $pendaftaran->update([
            'status_pendakian' => 'sedang_mendaki',
            'tanggal_check_in' => now(),
        ]);

        LogAdmin::create([
            'admin_id' => Auth::id(),
            'pendaftaran_id' => $pendaftaran->id,
            'aksi' => 'check_in',
            'keterangan' => 'Pendaki memulai pendakian (Check-In)',
        ]);

        // Kirim Notifikasi
        $pendaftaran->user->notify(new \App\Notifications\PendaftaranStatusChanged($pendaftaran, 'check_in'));

        return back()->with('success', 'Pendaki berhasil Check-In!');
    }

    public function checkOut($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        if ($pendaftaran->status_pendakian !== 'sedang_mendaki') {
            return back()->withErrors(['error' => 'Status pendakian tidak valid untuk Check-Out.']);
        }

        $pendaftaran->update([
            'status_pendakian' => 'selesai',
            'tanggal_check_out' => now(),
        ]);

        LogAdmin::create([
            'admin_id' => Auth::id(),
            'pendaftaran_id' => $pendaftaran->id,
            'aksi' => 'check_out',
            'keterangan' => 'Pendaki selesai mendakian (Check-Out)',
        ]);

        // Kirim Notifikasi
        $pendaftaran->user->notify(new \App\Notifications\PendaftaranStatusChanged($pendaftaran, 'check_out'));

        return back()->with('success', 'Pendaki berhasil Check-Out!');
    }
}
