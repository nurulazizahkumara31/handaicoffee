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
        Schema::create('gaji', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id');
            $table->integer('jumlah_hadir')->default(0);
            $table->integer('gaji_per_hari')->default(100000);
            $table->integer('total_gaji')->default(0);
            $table->timestamps();

            // FK bisa ditambahkan nanti kalau mau
            $table->foreign('pegawai_id')->references('id_pegawai')->on('pegawai')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji');
    }
};
