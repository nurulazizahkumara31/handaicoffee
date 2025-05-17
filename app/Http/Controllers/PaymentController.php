<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Voucher;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use App\Models\Payment;


use Barryvdh\DomPDF\Facade\Pdf;



class PaymentController extends Controller
{
    public function show($orderId)
    {
        $order = Order::with('details.product', 'pelanggan')->findOrFail($orderId);

        // Ambil voucher aktif dan belum expired
        $availableVouchers = Voucher::where('active', true)
            ->where(function ($query) {
                $query->whereNull('expiry_date')
                    ->orWhere('expiry_date', '>=', now());
            })
            ->get()
            ->map(function ($voucher) {
                return [
                    'code' => $voucher->code,
                    'description' => $voucher->description,
                    'type' => $voucher->type,
                    'value' => $voucher->value,
                    'start_date' => $voucher->start_date ? $voucher->start_date->format('d-m-Y') : '-',
                    'expiry_date' => $voucher->expiry_date ? $voucher->expiry_date->format('d-m-Y') : '-',
                    'active' => $voucher->active,
                    'discount' => 0,
                ];
            });


        return view('payment.index', compact('order', 'availableVouchers'));
    }


    public function processPayment(Request $request, $orderId)
    {
        // Validasi input dari form
        $request->validate([
            'address' => 'required|string',
            'delivery_option' => 'required|in:pickup,delivery',
            'voucher_code' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        // Ambil order berdasarkan ID, pastikan ada
        $order = Order::with('details.product')->findOrFail($orderId);

        // Hitung ongkos kirim (misal 2000 jika delivery, 0 jika pickup)
        $shippingCost = ($request->delivery_option == 'delivery') ? 2000 : 0;

        // Hitung total harga produk
        $totalProductPrice = $order->details->sum(function ($detail) {
            return $detail->quantity * $detail->product->price;
        });

        $voucherDiscount = 0;

        // Cek dan hitung diskon voucher jika ada kode voucher diinput
        if ($request->filled('voucher_code')) {
            $voucher = Voucher::where('code', $request->voucher_code)
                ->where('active', true)
                ->where(function ($query) {
                    $query->whereNull('expiry_date')->orWhere('expiry_date', '>=', now());
                })->first();

            if (!$voucher) {
                // Jika voucher tidak ditemukan atau tidak aktif
                return back()->withErrors(['voucher_code' => 'Voucher tidak ditemukan atau sudah tidak berlaku.'])->withInput();
            }

            // Hitung diskon voucher sesuai jenisnya
            if ($voucher->type === 'percentage') {
                $voucherDiscount = floor($totalProductPrice * ($voucher->value / 100));
            } else {
                $voucherDiscount = $voucher->value;
            }
        }

        // Hitung total pembayaran setelah diskon dan ongkir
        $totalPayment = $totalProductPrice + $shippingCost - $voucherDiscount;

        // Pastikan total pembayaran tidak negatif
        if ($totalPayment < 0) {
            $totalPayment = 0;
        }

        // Update data order dengan semua info terbaru
        $order->update([
            'address' => $request->address,
            'delivery_option' => $request->delivery_option,
            'note' => $request->note,
            'shipping_cost' => $shippingCost,
            'voucher_code' => $request->voucher_code,
            'voucher_discount' => $voucherDiscount,
            'total_price' => $totalPayment,
        ]);

        // TODO: Lanjutkan ke proses pembayaran (misal redirect ke Midtrans atau halaman konfirmasi)

        return redirect()->route('payment.show', $orderId)->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function getSnapToken(Request $request)
    {
        $order = Order::with('details.product')->findOrFail($request->order_id);

        // Ambil voucher_code dan delivery_option dari request jika dikirim, fallback ke database
        $voucherCode = $request->input('voucher_code', $order->voucher_code);
        $deliveryOption = $request->input('delivery_option', $order->delivery_option);

        // Hitung subtotal produk
        $subtotal = $order->details->sum(function ($detail) {
            return $detail->quantity * $detail->product->price;
        });

        // Hitung ongkos kirim
        $shippingCost = ($deliveryOption === 'delivery') ? 2000 : 0;

        // Hitung diskon voucher jika ada
        $voucherDiscount = 0;
        if ($voucherCode) {
            $voucher = Voucher::where('code', $voucherCode)
                ->where('active', true)
                ->where(function ($query) {
                    $query->whereNull('expiry_date')->orWhere('expiry_date', '>=', now());
                })->first();

            if ($voucher) {
                if ($voucher->type === 'percentage') {
                    $voucherDiscount = floor($subtotal * ($voucher->value / 100));
                } else {
                    $voucherDiscount = $voucher->value;
                }
            }
        }

        $grossAmount = $subtotal + $shippingCost - $voucherDiscount;
        if ($grossAmount < 0)
            $grossAmount = 0;

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order->id . '-' . time(),
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json(['snapToken' => $snapToken]);
    }

    public function pay(Request $request, $orderId)
    {
        $request->validate([
            'address' => 'required|string',
            'delivery_option' => 'required|in:pickup,delivery',
            'voucher_code' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        $order = Order::with('details.product', 'user')->findOrFail($orderId);

        // Hitung ongkos kirim
        $shippingCost = ($request->delivery_option === 'delivery') ? 2000 : 0;

        // Hitung total produk
        $totalProductPrice = $order->details->sum(function ($detail) {
            return $detail->quantity * $detail->product->price;
        });

        $voucherDiscount = 0;
        if ($request->filled('voucher_code')) {
            $voucher = Voucher::where('code', $request->voucher_code)
                ->where('active', true)
                ->where(function ($query) {
                    $query->whereNull('expiry_date')->orWhere('expiry_date', '>=', now());
                })
                ->first();

            if (!$voucher) {
                return response()->json(['error' => 'Voucher tidak ditemukan atau sudah tidak berlaku.'], 422);
            }

            if ($voucher->type === 'percentage') {
                $voucherDiscount = floor($totalProductPrice * ($voucher->value / 100));
            } else {
                $voucherDiscount = $voucher->value;
            }
        }

        $totalPayment = $totalProductPrice + $shippingCost - $voucherDiscount;
        if ($totalPayment < 0)
            $totalPayment = 0;

        // Update order data
        $order->update([
            'address' => $request->address,
            'delivery_option' => $request->delivery_option,
            'note' => $request->note,
            'shipping_cost' => $shippingCost,
            'voucher_code' => $request->voucher_code,
            'voucher_discount' => $voucherDiscount,
            'total_price' => $totalPayment,
        ]);

        // Generate Midtrans Snap Token
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order->id . '-' . time(),
                'gross_amount' => $totalPayment,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json(['snapToken' => $snapToken]);
    }

    public function callback(Request $request)
    {
        // Ambil order ID dari callback
        $orderIdWithTimestamp = $request->order_id;
        $orderId = explode('-', $orderIdWithTimestamp)[0];

        $order = Order::find($orderId);

        if (!$order) {
            return response(['message' => 'Order not found'], 404);
        }

        // Ambil data yang diperlukan untuk verifikasi
        $login = config('midtrans.client_key'); // Gunakan client_key atau server_key
        $password = config('midtrans.server_key'); // Gunakan server_key

        // Membuat request cURL ke Midtrans API untuk memeriksa status transaksi
        $ch = curl_init();
        $url = 'https://api.sandbox.midtrans.com/v2/' . $orderIdWithTimestamp . '/status';  // Ganti dengan API Midtrans yang sesuai
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        $output = curl_exec($ch);
        curl_close($ch);

        $outputJson = json_decode($output, true); // Parsing JSON dari response Midtrans

        // Cek jika ada error saat mengambil data
        if (isset($outputJson['error_message'])) {
            return response(['message' => $outputJson['error_message']], 400);
        }

        // Ambil status transaksi dari response
        $transactionStatus = $outputJson['transaction_status'];  // Capture, settlement, pending, dll.

        // Update status order berdasarkan status transaksi Midtrans
        if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
            $order->status = 'paid'; // Update status jadi paid
        } elseif ($transactionStatus === 'pending') {
            $order->status = 'pending'; // Status jika masih pending
        } else {
            $order->status = 'failed'; // Status jika gagal
        }

        $order->save(); // Simpan perubahan

        return response(['message' => 'Transaction status updated'], 200);
    }

    // public function midtransCallbackOld(Request $request)
//     {
//         return response()->json("asd");
//         // // Konfigurasi Midtrans
//         // Config::$serverKey = config(env('MIDTRANS_SERVER_KEY'));
//         // Config::$isProduction = false; // Ganti true kalau production
//         // Config::$isSanitized = true;
//         // Config::$is3ds = true;

    //         // // Ambil notifikasi dari Midtrans
//         // $notification = new Notification();

    //         // // Return seluruh data JSON untuk sementara
//         // return response()->json([
//         //     'transaction_status' => $notification->transaction_status,
//         //     'payment_type' => $notification->payment_type,
//         //     'order_id' => $notification->order_id,
//         //     'fraud_status' => $notification->fraud_status,
//         //     'status_message' => $notification->status_message
//         // ]);
//     }

    public function midtransCallback(Request $request)
    {
        try {
            // Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');


            // Ambil notifikasi dari Midtrans
            $notification = new Notification();

            // Ambil data penting
            $data = [
                'transaction_status' => $notification->transaction_status,
                'payment_type' => $notification->payment_type,
                'order_id' => $notification->order_id,
                'fraud_status' => $notification->fraud_status,
                'status_message' => $notification->status_message,
            ];

            // Ambil hanya ID sebelum tanda "-"
            $order_id_parts = explode('-', $notification->order_id);
            $order_id = $order_id_parts[0]; // Contoh: "23"

            // Ambil order dari database
            $order = Order::find($order_id);

            if (!$order) {
                return response()->json([
                    'message' => 'Order not found.',
                    'order_id' => $order_id
                ], 404);
            }

            // Jika transaksi settlement, update status di database
            if ($notification->transaction_status == "settlement") {
                $order->status = "paid";
                $order->save();

                // ⬇️ SIMPAN DATA PEMBAYARAN KE TABEL payments
                Payment::create([
                    'order_id' => $order->id,
                    'midtrans_order_id' => $notification->order_id,
                    'transaction_status' => $notification->transaction_status,
                    'gross_amount' => $notification->gross_amount,
                    'payment_type' => $notification->payment_type,
                    'transaction_time' => $notification->transaction_time,
                ]);
                
                // Kirim email invoice ke customer
                Mail::to($order->user->email)->send(new InvoiceMail($order));
            }

            // Return JSON dengan status 200 jika sukses
            return response()->json([
                'message' => 'Callback received successfully',
                'data' => $data,
            ], 200);

        } catch (Exception $e) {
            // Tangani error dan kirim response dengan status 400
            return response()->json([
                'message' => 'Callback failed',
                'error' => $e->getMessage(),
            ], 400);
        }
    }


    // ... kode lain tetap sama ...

    public function success(Request $request)
    {

        $orderIdWithTimestamp = $request->query('order_id');
        // dd($orderIdWithTimestamp);  // Cek apakah data order berhasil diambil
        if (!$orderIdWithTimestamp) {
            abort(404, 'Order ID tidak ditemukan');
        }

        $orderId = explode('-', $orderIdWithTimestamp)[0];

        $order = Order::with('details.product', 'user')->findOrFail($orderId);

        // dd($order);  // Cek apakah data order berhasil diambil

        if ($order->status !== 'paid') {
            abort(403, 'Pembayaran belum dikonfirmasi');
        }

        return view('payment.success', compact('order'));
    }

    public function downloadInvoice($orderId)
{
    $order = Order::with('user', 'details.product')->findOrFail($orderId);
    $pdf = Pdf::loadView('pdf.invoice', compact('order'));
    return $pdf->download('invoice_order_' . $orderId . '.pdf');
}
}


