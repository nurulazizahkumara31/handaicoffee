<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Define the table name (if different from the pluralized model name)
    protected $table = 'produk';

    // Define the primary key (if different from the default 'id')
    protected $primaryKey = 'id_produk';

    // Define the fields that are mass assignable
    protected $fillable = [
        'code_product',
        'name_product',
        'description',
        'price',
        'stock',
        'image',
        'expire_date',
    ];

    // Define any fields that should be treated as dates (like timestamps)
    protected $dates = ['expire_date']; // For the expire_date field
}
