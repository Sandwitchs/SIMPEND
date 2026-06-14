<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaPendaftaran extends Model
{
    protected $table = 'anggota_pendaftaran';
    protected $fillable = [
        'pendaftaran_id', 'nama', 'no_ktp', 'usia', 'no_hp'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
