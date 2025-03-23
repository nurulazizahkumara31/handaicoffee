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
        schema::create('pegawai',function(Blueprint $table){
          $table->id();
          $table->integer('id_pegawai');
          $table->string('nama_pegawai');
          $table->string('nohp_pegawai');
          $table->string('alamat');
          $table->string('posisi');
          $table->timestamps();
      });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};