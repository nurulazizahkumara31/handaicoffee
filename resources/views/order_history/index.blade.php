@extends('layouts.app')

@section('content')

{{-- CSS langsung di dalam file --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
    }

    .title-green {
        color: #10B981; /* Tailwind green-500 */
    }

    .btn-back-top {
        color: #10B981;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        transition: color 0.3s ease;
        text-decoration: none;
    }

    .btn-back-top:hover {
        color: #047857; /* Tailwind green-700 */
    }

    .btn-back-bottom {
        background-color: #d1d5db; /* gray-300 */
        color: #1f2937; /* gray-800 */
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        transition: background-color 0.3s ease;
        text-decoration: none;
    }

    .btn-back-bottom:hover {
        background-color: #9ca3af; /* gray-400 */
    }

    .badge-paid {
        background-color: #d1fae5;
        color: #047857;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-unpaid {
        background-color: #fef3c7;
        color: #92400e;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>

<div class="bg-[var(--light-green)] min-h-screen py-10 px-4">
    <div class="max-w-5xl mx-auto">

        {{-- Tombol Back ke Dashboard --}}
        <a href="{{ route('das') }}" class="btn-back-top">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>

        <h2 class="text-3xl font-bold title-green mb-8 text-center mt-4">Order History</h2>

        @forelse ($orders as $order)
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-6 p-6 transition hover:shadow-md">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-lg font-semibold text-gray-800">
                    Order #{{ $order->id }}
                </h3>
                <span class="text-sm text-gray-500">{{ $order->created_at->format('d M Y - H:i') }}</span>
            </div>

            <div class="flex flex-wrap gap-4 mb-4 text-sm text-gray-700">
                <div>
                    <span class="font-semibold">Status:</span>
                    <span class="{{ $order->status === 'paid' ? 'badge-paid' : 'badge-unpaid' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div>
                    <span class="font-semibold">Payment:</span>
                    {{ optional($order->payments)->transaction_status ?? 'Belum Dibayar' }}
                </div>
            </div>

            <div class="border-t border-gray-200 pt-3 mb-3">
                <ul class="list-disc list-inside text-sm text-gray-800">
                    @foreach ($order->orderDetails as $detail)
                        <li>{{ $detail->product->name_product }} x {{ $detail->quantity }} 
                            (Rp{{ number_format($detail->price, 0, ',', '.') }})</li>
                    @endforeach
                </ul>
            </div>

            <div class="flex justify-between items-center mt-4">
                <p class="text-base font-bold text-gray-900">
                    Total: Rp{{ number_format($order->total_price, 0, ',', '.') }}
                </p>
                <a href="{{ route('order.invoice', $order->id) }}"
                   target="_blank"
                   class="inline-flex items-center gap-1 px-4 py-2 bg-green-600 text-white rounded-md text-sm font-semibold hover:bg-green-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v12a2 2 0 01-2 2z" />
                    </svg>
                    Invoice
                </a>
            </div>
        </div>
        @empty
            <div class="text-center text-gray-500 text-sm">
                Belum ada pesanan. Yuk, order dulu di <a href="{{ route('menu') }}" class="text-[var(--primary-green)] font-medium hover:underline">Menu</a>!
            </div>
        @endforelse

        {{-- Tombol Back Tambahan di Bawah --}}
        <div class="mt-10 text-center">
            <a href="{{ url()->previous() }}" class="btn-back-bottom">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
        </div>
    </div>
</div>
@endsection
