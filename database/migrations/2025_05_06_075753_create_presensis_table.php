<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();

            // Kolom foreign key
            $table->unsignedBigInteger('user_id');

            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->timestamps();

            // Hubungkan ke pegawai
            $table->foreign('user_id')
                ->references('id_pegawai')
                ->on('pegawai')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
