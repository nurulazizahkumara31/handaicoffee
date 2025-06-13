<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'pelanggan_id',
        'items',
        'total_price',
        'shipping_cost',       // baru
        'voucher_code',        // baru
        'voucher_discount',    // baru
        'status',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    // Relasi ke tabel order_details
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // app/Models/Order.php
    public function orderDetails()
    {
        return $this->hasMany(\App\Models\OrderDetail::class);
    }

    public function payments()
    {
        return $this->hasOne(\App\Models\Payment::class); // asumsi 1 order 1 payment
    }

}
