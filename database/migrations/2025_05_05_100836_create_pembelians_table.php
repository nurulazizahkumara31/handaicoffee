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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kode_supplier')->constrained('supplier')->onDelete('cascade');
            $table->string('no_invoice'); 
            $table->datetime('tanggal'); 
            $table->decimal('total', 15, 2)->nullable();
            $table->string('status');
            $table->string('foto_faktur');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
