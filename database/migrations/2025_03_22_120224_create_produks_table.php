<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk'); // AUTO_INCREMENT PRIMARY KEY
            $table->string('code_product', 15)->unique(); // Kode produk dengan huruf
            $table->string('name_product'); // VARCHAR
            $table->text('description'); // TEXT
            $table->decimal('price', 10, 2); // DECIMAL(10,2)
            $table->integer('stock'); // INTEGER
            $table->string('image'); // VARCHAR
            $table->string('expire_date')->nullable();
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk');
    }
};