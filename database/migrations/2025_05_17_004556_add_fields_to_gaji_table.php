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
        Schema::table('gaji', function (Blueprint $table) {
            $table->unsignedBigInteger('pegawai_id')->after('id');
            $table->integer('jumlah_hadir')->default(0)->after('pegawai_id');
            $table->integer('gaji_per_hari')->default(100000)->after('jumlah_hadir');
            $table->integer('total_gaji')->default(0)->after('gaji_per_hari');

            // FK optional
            $table->foreign('pegawai_id')->references('id_pegawai')->on('pegawai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gaji', function (Blueprint $table) {
            $table->dropForeign(['pegawai_id']); // uncomment kalau FK dipakai
            $table->dropColumn(['pegawai_id', 'jumlah_hadir', 'gaji_per_hari', 'total_gaji']);
        });
    }
};
