<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // id pesanan
            $table->unsignedBigInteger('user_id'); // relasi ke users
            $table->unsignedBigInteger('pelanggan_id'); // relasi ke pelanggan
            $table->json('items'); // data produk dalam bentuk json
            $table->integer('total_price'); // total harga
            $table->enum('status', ['pending', 'paid'])->default('pending'); // status pesanan
            $table->timestamps();

            // Relasi foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
