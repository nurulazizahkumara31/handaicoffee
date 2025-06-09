<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('shipping_cost')->default(0)->after('items');
            $table->string('voucher_code')->nullable()->after('shipping_cost');
            $table->integer('voucher_discount')->default(0)->after('voucher_code');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_cost', 'voucher_code', 'voucher_discount']);
        });
    }
};
