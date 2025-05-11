<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    public function show($orderId)
    {
        $order = Order::with('details.product')->findOrFail($orderId);

        return view('payment.index', compact('order'));
    }
}
