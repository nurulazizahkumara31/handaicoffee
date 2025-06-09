<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Jurnal;
use App\Models\JurnalDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentSyncService
{
    public function sync()
    {
        $payments = Payment::where('transaction_status', 'paid')
            ->where('jurnal_created', 0)
            ->get();

        foreach ($payments as $payment) {
            DB::beginTransaction();
            try {
                $jurnal = Jurnal::create([
                    'tgl' => Carbon::parse($payment->transaction_time),
                    'deskripsi' => 'Pembayaran Order #' . $payment->order_id,
                ]);

                JurnalDetail::create([
                    'jurnal_id' => $jurnal->id,
                    'coa_id' => 1,
                    'debit' => $payment->gross_amount,
                    'credit' => 0,
                ]);

                JurnalDetail::create([
                    'jurnal_id' => $jurnal->id,
                    'coa_id' => 2,
                    'debit' => 0,
                    'credit' => $payment->gross_amount,
                ]);

                $payment->update(['jurnal_created' => 1]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                // Simpan log error atau kirim notifikasi
            }
        }
    }
}
