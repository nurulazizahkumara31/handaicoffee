<?php

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'code_product',
        'name_product',
        'description',
        'price',
        'stock',
        'image',
        'expire_date',
    ];

    protected $dates = ['expire_date']; // Untuk tanggal expire, bisa gunakan format date

}
