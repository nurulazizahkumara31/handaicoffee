<!-- <?php -->

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// class CreateOrdersTable extends Migration
// {
//     public function up(): void
//     {
//         if (!Schema::hasTable('orders')) {
//             Schema::create('orders', function (Blueprint $table) {
//                 $table->id();
//                 $table->unsignedBigInteger('user_id');
//                 $table->string('product_name');
//                 $table->integer('quantity');
//                 $table->decimal('price', 8, 2);
//                 $table->timestamps();

//                 // Optional: Foreign key constraint
//                 // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//             });
//         }
//     }

//     public function down(): void
//     {
//         Schema::dropIfExists('orders');
//     }
// }
//         Schema::create('orders', function (Blueprint $table) {
//             $table->id();
//             $table->unsignedBigInteger('user_id');
//             $table->unsignedBigInteger('pelanggan_id');
//             $table->json('items');
//             $table->string('voucher_code')->nullable(); // ✅ Tanpa after
//             $table->integer('voucher_discount')->default(0); // ✅ Tanpa after
//             $table->integer('total_price');
//             $table->enum('status', ['pending', 'paid'])->default('pending');
//             $table->timestamps();

//             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//             $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
//         });
    // }

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['voucher_code', 'voucher_discount']);
    });
// }

    
// };


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

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
        });
    }

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
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
