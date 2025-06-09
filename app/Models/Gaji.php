<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gaji'; // Nama tabel sesuai database

    protected $fillable = [
        'pegawai_id',      // ganti user_id ke pegawai_id agar konsisten
        'jumlah_hadir',
        'gaji_per_hari',
        'total_gaji',
    ];

    // Relasi ke model Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id_pegawai');
    }
}
