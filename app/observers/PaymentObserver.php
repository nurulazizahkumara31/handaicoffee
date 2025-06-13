<?php
namespace App\Observers;

use App\Models\Payment;
use App\Models\Jurnal;
use App\Models\JurnalDetail;
use Carbon\Carbon;
//nurul
class PaymentObserver
{
    public function updated(Payment $payment)
    {
        if ($payment->transaction_status === 'paid' && !$payment->jurnal_created) {
            // Buat Jurnal
            $jurnal = Jurnal::create([
                'tgl' => Carbon::parse($payment->transaction_time)->format('Y-m-d'),
                'no_referensi' => 'ORDER-' . $payment->order_id,
                'deskripsi' => 'Pembayaran Order #' . $payment->order_id,
            ]);

            // Buat Detail Jurnal (2 baris: debit dan kredit)
            JurnalDetail::create([
                'jurnal_id' => $jurnal->id,
                'coa_id' => 1, // ID akun kas (misalnya: Kas / Bank)
                'debit' => $payment->gross_amount,
                'credit' => 0,
                'deskripsi' => 'Masuk kas dari order',
            ]);

            JurnalDetail::create([
                'jurnal_id' => $jurnal->id,
                'coa_id' => 2, // ID akun penjualan
                'debit' => 0,
                'credit' => $payment->gross_amount,
                'deskripsi' => 'Pendapatan dari order',
            ]);

            // Tandai bahwa jurnal sudah dibuat
            $payment->updateQuietly(['jurnal_created' => true]);
        }
    }
}
