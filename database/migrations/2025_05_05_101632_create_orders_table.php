<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('pelanggan_id');
                $table->json('items');
                $table->string('voucher_code')->nullable();
                $table->integer('voucher_discount')->default(0);
                $table->integer('total_price');
                $table->enum('status', ['pending', 'paid'])->default('pending');
                $table->timestamps();

                // Foreign keys
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
            });
        }
        /**
     * Reverse the migrations.
     */
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}