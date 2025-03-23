<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class BahanBaku extends Model
{
    use HasFactory;

    protected $table = 'bahan_baku'; // Nama tabel eksplisit

    protected $guarded = [];

    public static function getKodeBahanBaku()
    {
        // query kode perusahaan
        $sql = "SELECT IFNULL(MAX(kode_bahan_baku), 'BB000') as kode_bahan_baku
                FROM bahan_baku ";
        $kode_bahan_baku = DB::select($sql);

        // cacah hasilnya
        foreach ($kode_bahan_baku as $kdbb) {
            $kd = $kdbb->kode_bahan_baku;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($kd,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        $noakhir = 'BB'.str_pad($noakhir,3,"0",STR_PAD_LEFT); //menyambung dengan string PR-001
        return $noakhir;

    }

    // Dengan mutator ini, setiap kali data harga_barang dikirim ke database, koma akan otomatis dihapus.
    public function setHargaBahanBakuAttribute($value)
    {
        // Hapus koma (,) dari nilai sebelum menyimpannya ke database
        $this->attributes['harga_satuan'] = str_replace('.', '', $value);
    }
}
