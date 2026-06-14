<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';
    protected $fillable = [
        'user_id', 'gunung_id', 'id_booking', 'nama_ketua', 
        'tanggal_pendakian', 'jumlah_anggota', 'jenis_pendakian', 'status_verifikasi',
        'alasan_penolakan', 'tanggal_verifikasi', 'dokumen_ktp', 'dokumen_sehat',
        'status_pembayaran', 'total_harga', 'status_pendakian', 'tanggal_check_in', 'tanggal_check_out'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gunung()
    {
        return $this->belongsTo(Gunung::class);
    }

    public function anggota()
    {
        return $this->hasMany(AnggotaPendaftaran::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getSisaKuotaAttribute()
    {
        $terisi = Pendaftaran::where('gunung_id', $this->gunung_id)
            ->where('tanggal_pendakian', $this->tanggal_pendakian)
            ->where('status_verifikasi', 'disetujui')
            ->sum('jumlah_anggota');
        return $this->gunung->kuota_maks - $terisi;
    }

    public function getIsOverdueAttribute()
    {
        if ($this->status_pendakian !== 'sedang_mendaki') {
            return false;
        }

        $tanggal_pendakian = \Carbon\Carbon::parse($this->tanggal_pendakian);
        $batas_waktu = $this->jenis_pendakian === 'camp' 
            ? $tanggal_pendakian->addDay()->endOfDay() 
            : $tanggal_pendakian->endOfDay();

        return now()->gt($batas_waktu);
    }

    public function getStatusPendakianLabelAttribute()
    {
        if ($this->status_pendakian === 'sedang_mendaki' && $this->is_overdue) {
            return 'OVERDUE';
        }
        return strtoupper(str_replace('_', ' ', $this->status_pendakian));
    }
}
