@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mt-8">
    <h1 class="text-2xl font-bold mb-6">Invoice Pembayaran</h1>

    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Nama Pelanggan:</strong> {{ $order->user->name }}</p>
    <p><strong>Tanggal:</strong> {{ $order->updated_at->format('d-m-Y H:i') }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

    <hr class="my-4">

    <h2 class="font-semibold mb-2">Detail Produk</h2>
    <table class="w-full border-collapse border">
        <thead>
            <tr>
                <th class="border p-2 text-left">Produk</th>
                <th class="border p-2 text-right">Harga</th>
                <th class="border p-2 text-center">Jumlah</th>
                <th class="border p-2 text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->details as $detail)
            <tr>
                <td class="border p-2">{{ $detail->product->name_product }}</td>
                <td class="border p-2 text-right">Rp{{ number_format($detail->product->price, 0, ',', '.') }}</td>
                <td class="border p-2 text-center">{{ $detail->quantity }}</td>
                <td class="border p-2 text-right">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <hr class="my-4">

    <div class="flex justify-end space-x-10 text-lg font-semibold">
        <div>
            <p>Ongkos Kirim: Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
            <p>Diskon Voucher: Rp{{ number_format($order->voucher_discount, 0, ',', '.') }}</p>
            <p>Total: Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="mt-8 flex space-x-4">
    <a href="{{ route('payment.invoice.pdf', $order->id) }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    Download PDF
    </a>    
    </div>
</div>
@endsection
