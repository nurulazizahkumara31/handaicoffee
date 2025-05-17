<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voucher', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();           // Kode voucher unik
            $table->string('description')->nullable();  // Deskripsi voucher
            $table->enum('type', ['percentage', 'fixed']); // Tipe diskon
            $table->integer('value');                    // Nilai diskon (misal 10% atau 5000)
            $table->integer('min_order')->default(0);   // Minimal pembelian supaya voucher bisa dipakai
            $table->date('start_date')->nullable();     // Tanggal mulai berlaku
            $table->date('expiry_date')->nullable();    // Tanggal expired
            $table->boolean('active')->default(true);   // Status aktif/tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voucher');
    }
};