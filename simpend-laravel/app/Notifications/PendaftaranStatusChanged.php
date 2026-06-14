<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PendaftaranStatusChanged extends Notification
{
    use Queueable;

    protected $pendaftaran;
    protected $type; // 'disetujui', 'ditolak', 'check_in', 'check_out'

    public function __construct($pendaftaran, $type)
    {
        $this->pendaftaran = $pendaftaran;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $message = '';
        if ($this->type === 'disetujui') {
            $message = "Pendaftaran pendakian Anda dengan ID Booking {$this->pendaftaran->id_booking} telah DISETUJUI oleh admin. Silakan lakukan pembayaran jika belum.";
        } elseif ($this->type === 'ditolak') {
            $alasan = $this->pendaftaran->alasan_penolakan ? " Alasan: " . $this->pendaftaran->alasan_penolakan : "";
            $message = "Pendaftaran pendakian Anda dengan ID Booking {$this->pendaftaran->id_booking} telah DITOLAK oleh admin.{$alasan}";
        } elseif ($this->type === 'check_in') {
            $message = "Status pendakian Anda untuk ID Booking {$this->pendaftaran->id_booking} telah dimulai (Check-In). Tetap utamakan keselamatan dan jaga kelestarian alam!";
        } elseif ($this->type === 'check_out') {
            $message = "Status pendakian Anda untuk ID Booking {$this->pendaftaran->id_booking} dinyatakan selesai (Check-Out). Terima kasih telah menyelesaikan pendakian dengan selamat!";
        }

        return [
            'pendaftaran_id' => $this->pendaftaran->id,
            'id_booking' => $this->pendaftaran->id_booking,
            'type' => $this->type,
            'message' => $message,
        ];
    }
}
