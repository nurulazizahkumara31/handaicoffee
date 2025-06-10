<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'no_invoice',
        'user_id',
        'pelanggan_id',
        'items',
        'total_price',
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
}
