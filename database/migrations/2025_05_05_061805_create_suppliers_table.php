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
        if (!Schema::hasTable('presensis')) {
        Schema::create('supplier', function (Blueprint $table) {
            $table->id();
            $table->string('kode_supplier');
            $table->string('nama_supplier');
            $table->integer('no_telp');
            $table->string('alamat');
            $table->timestamps();
        });
    }}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier');
    }
};
