<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Voucher extends Model
{
    use HasFactory;

    protected $table = 'voucher'; // Nama tabel eksplisit

    protected $guarded = []; // Bisa diganti menjadi $fillable jika Anda ingin lebih aman dari mass-assignment

    protected $fillable = [
        'code', 'description', 'type', 'value', 'active', 'start_date', 'expiry_date'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'expiry_date' => 'datetime',
    ];
    // Mendapatkan kode jasa baru
}
