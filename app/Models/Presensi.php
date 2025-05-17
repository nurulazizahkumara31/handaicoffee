<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//bismillah
class Presensi extends Model
{
    protected $table = 'presensis';

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'pegawai_id',
        'status', // tambah ini
    ];
    

  public function pegawai()
{
    return $this->belongsTo(Pegawai::class, 'user_id', 'id_pegawai');
}


    

}
