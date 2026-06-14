<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function view($type, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        // Otorisasi: Hanya admin atau pemilik pendaftaran yang boleh mengakses dokumen
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $pendaftaran->user_id) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        if ($type === 'ktp') {
            $path = $pendaftaran->dokumen_ktp;
        } elseif ($type === 'sehat') {
            $path = $pendaftaran->dokumen_sehat;
        } else {
            abort(404, 'Tipe dokumen tidak valid.');
        }

        if (!$path || !Storage::disk('local')->exists($path)) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        return Storage::disk('local')->response($path);
    }
}
