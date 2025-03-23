<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk'); // INTEGER (AUTO_INCREMENT PRIMARY KEY)
            $table->string('nama_produk'); // VARCHAR
            $table->text('deskripsi'); // TEXT
            $table->decimal('harga', 10, 2); // DECIMAL(10,2)
            $table->integer('stok'); // INTEGER
            $table->string('gambar'); // VARCHAR
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk');
    }
};

