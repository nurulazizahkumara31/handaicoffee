<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier'; // Nama tabel eksplisit

    protected $guarded = [];

    public static function getKodeSupplier()
    {
        // query kode perusahaan
        $sql = "SELECT IFNULL(MAX(kode_supplier), 'SP000') as kode_supplier
                FROM supplier ";
        $kode_supplier = DB::select($sql);

        // cacah hasilnya
        foreach ($kode_supplier as $kdsp) {
            $kd = $kdsp->kode_supplier;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($kd,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        $noakhir = 'SP'.str_pad($noakhir,3,"0",STR_PAD_LEFT); //menyambung dengan string PR-001
        return $noakhir;
    }
}
