<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class VoucherSeeder extends Seeder
{
    public function run()
    {
        DB::table('vouchers')
            ->whereNull('start_date')
            ->orWhereNull('expiry_date')
            ->update([
                'start_date' => now()->startOfMonth(),
                'expiry_date' => now()->endOfMonth(),
  ]);
    }
}
