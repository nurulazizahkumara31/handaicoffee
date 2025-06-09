<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;

    protected $table = 'detail_pembelian';

    protected $fillable = ['kode_pembelian', 'kode_bahan_baku', 'jumlah', 'harga_satuan', 'subtotal'];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'kode_pembelian');
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'kode_bahan_baku');
    }

}
