<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use App\Models\Jurnal;
use App\Models\JurnalDetail;
use App\Models\Coa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SyncPaymentsToJurnal extends Command
{
    protected $signature = 'sync:payments-to-jurnal';
    protected $description = 'Sinkronisasi pembayaran yang statusnya paid ke jurnal';

    public function handle()
    {
        $payments = Payment::where('transaction_status', 'settlement')
            ->where('jurnal_created', 0)
            ->get();

        // Cari akun COA
        $akunKas = Coa::where('header_akun', 1)->first();        // 1 = Kas
        $akunPendapatan = Coa::where('header_akun', 4)->first(); // 4 = Penjualan

        if (!$akunKas || !$akunPendapatan) {
            $this->error("Akun Kas atau Pendapatan tidak ditemukan di tabel COA.");
            return;
        }

        $total = 0;

    foreach ($payments as $payment) {
        DB::beginTransaction();
        try {
            // 1. Buat entri jurnal
            $jurnal = Jurnal::create([
                'tgl' => \Carbon\Carbon::parse($payment->transaction_time),
                'deskripsi' => 'Pembayaran Order #' . $payment->order_id,
            ]);

            // 2. Detail: Debet Kas, Kredit Pendapatan
            JurnalDetail::create([
                'jurnal_id' => $jurnal->id,
                'coa_id' => 3, // ID COA untuk Kas (cek dari database kamu)
                'debit' => $payment->gross_amount,
                'credit' => 0,
            ]);

            JurnalDetail::create([
                'jurnal_id' => $jurnal->id,
                'coa_id' => 4, // ID COA untuk Pendapatan (cek dari database kamu)
                'debit' => 0,
                'credit' => $payment->gross_amount,
            ]);

            // 3. Commit dulu
            DB::commit();

            // 4. Update status di luar transaksi supaya tidak kena rollback
            $payment->update(['jurnal_created' => 1]);

            $total++;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Gagal untuk payment ID {$payment->id}: {$e->getMessage()}");
        }
    }


        $this->info("Sinkronisasi selesai. Total: {$total} payment diproses.");
    }
}
