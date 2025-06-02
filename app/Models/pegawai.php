<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai'; // Pastikan tabel tidak pakai "s"
    protected $primaryKey = 'id_pegawai';
    
    protected $fillable = [
        'id_pegawai',
        'nama_pegawai',
        'nohp_pegawai',
        'alamat',
        'posisi',
    ];

 public function presensis()
{
    return $this->hasMany(Presensi::class, 'user_id', 'id_pegawai');
}

    // relasi ke gaji (jika ada)
    public function gajis()
    {
        return $this->hasMany(Gaji::class, 'pegawai_id', 'id_pegawai');
    }


}