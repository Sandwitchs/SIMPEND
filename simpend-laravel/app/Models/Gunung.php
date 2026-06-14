<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gunung extends Model
{
    protected $table = 'gunung';
    protected $fillable = [
        'nama_gunung', 'jalur', 'kuota_maks', 'harga_per_orang', 'harga_per_orang_tektok',
    ];

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
