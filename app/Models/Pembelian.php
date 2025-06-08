<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// untuk tambahan db
use Illuminate\Support\Facades\DB;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian'; // Nama tabel eksplisit

    protected $fillable = ['kode_supplier', 'no_invoice', 'tanggal', 'total', 'status', 'foto_faktur'];

    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'kode_supplier');
    }

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'kode_pembelian');
    }

    public function getTotalAttribute()
    {
        return $this->detailPembelian->sum(function ($detail) {
            return $detail->subtotal ?? ($detail->jumlah * $detail->harga_satuan);
        });
    }

}
