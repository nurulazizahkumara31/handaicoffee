<?php

// app/Models/Pelanggan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika tidak sesuai dengan konvensi plural
    protected $table = 'pelanggan';

    protected $fillable = [
        'nama', 'email', 'telepon', 'alamat', 'user_id',
    ];
}

