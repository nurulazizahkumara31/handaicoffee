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
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pelanggan_id');
            $table->json('items');
            $table->string('voucher_code')->nullable(); // ✅ Tanpa after
            $table->integer('voucher_discount')->default(0); // ✅ Tanpa after
            $table->integer('total_price');
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['voucher_code', 'voucher_discount']);
    });
}

    
};


