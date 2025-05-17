<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'midtrans_order_id',
        'snap_token',
        'transaction_status',
        'gross_amount',
        'payment_type',
        'transaction_time',
    ];

    // Relasi optional: satu pembayaran milik satu order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
