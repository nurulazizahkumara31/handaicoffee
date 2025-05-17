<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//bismillah
class Presensi extends Model
{
    protected $table = 'presensis';

    protected $fillable = [
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'user_id',
        'status',
    ];
    
    

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'user_id', 'id_pegawai');
    }
}
