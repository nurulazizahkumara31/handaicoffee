@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-12 text-center">
    <h1 class="text-2xl font-bold text-green-700 mb-4">Pembayaran</h1>
    <p class="mb-2">Nomor Pesanan: #{{ $order->id }}</p>
    <p class="text-lg font-semibold mb-6">Total: Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>

    {{-- Tombol simulasi pembayaran --}}
    <form action="#" method="POST">
        <button class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
            Bayar Sekarang
        </button>
    </form>

    {{-- Tombol Kembali ke Menu --}}
    <div class="mt-6">
        <a href="{{ route('menu') }}" class="inline-block text-sm text-green-600 hover:underline">
            ← Kembali ke Menu
        </a>
    </div>
</div>
@endsection
