<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class CobaMidtransController extends Controller
{
    public function getSnapToken(Request $request)
{
    $total = $request->input('total');

    $order = Order::latest()->first();

    $midtransParams = [
        'transaction_details' => [
            'order_id' => 'ORDER-' . $order->id . '-' . time(),
            'gross_amount' => $total,
        ],
        'customer_details' => [
            'first_name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ],
    ];

    \Midtrans\Config::$serverKey = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    $snapToken = \Midtrans\Snap::getSnapToken($midtransParams);
    return response()->json(['snapToken' => $snapToken]);
}

}
    