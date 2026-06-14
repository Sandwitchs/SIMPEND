<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAdmin extends Model
{
    protected $table = 'log_admin';
    protected $fillable = [
        'admin_id', 'pendaftaran_id', 'aksi', 'keterangan'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
