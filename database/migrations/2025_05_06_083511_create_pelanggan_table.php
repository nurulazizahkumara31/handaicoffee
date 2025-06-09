<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id(); // id_pelanggan
            $table->string('nama');
            $table->string('email')->nullable(); // Bisa nullable jika tidak wajib
            $table->string('telepon');
            $table->text('alamat');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
