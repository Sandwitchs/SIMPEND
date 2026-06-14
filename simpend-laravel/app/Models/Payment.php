<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'pendaftaran_id', 'order_id', 'transaction_id', 'payment_type',
        'transaction_status', 'gross_amount', 'payment_code', 'transaction_time'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
