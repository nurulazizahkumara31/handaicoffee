<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderDetails.product', 'payments'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('order_history.index', compact('orders'));
    }

    public function invoice(Order $order)
{
    // Batasi agar user hanya bisa lihat invoice miliknya
    if ($order->user_id !== auth()->id()) {
        abort(403, 'Akses ditolak');
    }

    return view('order_history.invoice', compact('order'));
}
}
