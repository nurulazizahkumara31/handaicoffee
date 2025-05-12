<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Jasa extends Model
{
    use HasFactory;

    protected $table = 'jasa'; // Nama tabel eksplisit

    protected $guarded = []; // Bisa diganti menjadi $fillable jika Anda ingin lebih aman dari mass-assignment

    // Mendapatkan kode jasa baru
    public static function getKodeJasa()
    {
        // query kode jasa
        $sql = "SELECT IFNULL(MAX(kode_jasa), 'JS000') as kode_jasa 
                FROM jasa";
        $kodeJasa = DB::select($sql);

        // mengambil hasilnya
        foreach ($kodeJasa as $kode) {
            $kd = $kode->kode_jasa;
        }
        
        // Menambahkan angka pada kode jasa
        $noAwal = substr($kd, -3); // mengambil 3 digit akhir dari kode
        $noAkhir = $noAwal + 1; // menambahkan 1 ke angka terakhir
        $noAkhir = 'AB' . str_pad($noAkhir, 3, "0", STR_PAD_LEFT); // menyambung dengan kode awal 'AB' dan menjadikannya 3 digit
        return $noAkhir;
    }

    // Mutator untuk menghapus tanda koma (.) pada harga jasa sebelum disimpan ke database
    public function setHargaJasaAttribute($value)
    {
        // Menghapus titik (.) dari harga jasa yang diinputkan (misalnya, 1.000 menjadi 1000)
        $this->attributes['harga'] = str_replace('.', '', $value);
    }

    // Relasi dengan tabel PenjualanBarang
    // Jika Anda memiliki relasi dengan tabel lain (seperti transaksi atau kategori), buat relasi disini

}

