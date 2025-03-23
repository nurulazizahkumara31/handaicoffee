<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk'; // Nama tabel eksplisit
    protected $primaryKey = 'id_produk'; // Primary key manual
    public $incrementing = false; // Non-incrementing ID
    protected $keyType = 'string'; // Tipe data primary key
    protected $guarded = [];

    public static function getKodeProduk()
    {
        // Query kode produk
        $sql = "SELECT id_produk FROM produk ORDER BY id_produk DESC LIMIT 1";
        $kodeproduk = DB::select($sql);

        // Jika tidak ada data, mulai dari PR001
        if (empty($kodeproduk)) {
            return '001';
        }
    }

    // Mutator untuk menghapus koma dari harga sebelum disimpan ke database
    public function setHargaAttribute($value)
    {
        $this->attributes['harga'] = str_replace(',', '', $value);
    }
}
