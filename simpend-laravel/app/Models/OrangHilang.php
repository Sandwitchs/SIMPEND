<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangHilang extends Model
{
    protected $table = 'orang_hilang';

    protected $fillable = [
        'nama',
        'umur',
        'lokasi_terakhir',
        'tanggal_hilang',
        'deskripsi_terakhir',
        'foto',
        'status',
        'kontak_keluarga',
    ];

    protected $casts = [
        'tanggal_hilang' => 'date',
    ];
}
