@if(session('error'))
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">

  <!-- Back Button -->
  <a href="/menu" class="inline-flex items-center gap-2 text-sm text-green-600 hover:text-green-800 font-semibold mb-6 transition duration-200">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Back to Menu
  </a>

  <h2 class="text-3xl font-extrabold text-center text-green-700 mb-10">🛒 Your Cart</h2>

  @if (count($cart) > 0)
  @php 
    $total = 0; 
    $shipping = 5000; 
  @endphp

  <!-- Cart List -->
  <div class="space-y-6" id="cart-list">
    @foreach ($cart as $id => $item)
      @php 
        $subtotal = $item['price'] * $item['quantity']; 
        $total += $subtotal;
      @endphp
      <div class="flex flex-wrap items-center justify-between border p-4 rounded-2xl bg-white shadow hover:shadow-lg transition" data-item-id="{{ $id }}">
        <div class="flex items-center gap-4 w-full sm:w-auto">
          <img src="{{ asset('storage/' . $item['image']) }}" class="w-16 h-16 object-cover rounded border shadow" alt="{{ $item['name'] }}">

          <div>
            <h4 class="font-semibold text-lg text-gray-800">{{ $item['name'] }}</h4>
            <div class="flex items-center gap-2 mt-1">
              <label for="qty{{ $id }}" class="text-sm text-gray-600">Qty:</label>
              <input id="qty{{ $id }}" type="number" name="quantity[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" class="w-16 p-2 border rounded-md text-center">
            </div>
          </div>
        </div>
        <div class="flex items-center justify-between mt-4 sm:mt-0 w-full sm:w-auto gap-4">
          <span class="font-bold text-gray-700 subtotal" data-item-id="{{ $id }}">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
          <form action="{{ route('cart.delete', $id) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800 text-lg">
              <i class="fas fa-trash-alt"></i>
            </button>
          </form>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Total -->
  <div class="bg-white mt-10 p-6 rounded-2xl shadow-lg text-sm text-gray-700 space-y-3">
    <div class="flex justify-between">
      <span>Subtotal</span>
      <span id="subtotal">Rp{{ number_format($total, 0, ',', '.') }}</span>
    </div>
    <div class="flex justify-between font-semibold text-lg border-t pt-3">
      <span>Total</span>
      <span id="total" class="text-green-700">Rp{{ number_format($total, 0, ',', '.') }}</span>
    </div>
  </div>

  <form action="{{ route('cart.checkout') }}" method="POST" class="text-center mt-6">
    @csrf
    <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-green-700 transition-all">
        Checkout
    </button>
  </form>

  @else
  <div class="text-center text-gray-500 mt-12 text-lg">
    🛍️ Your cart is empty. Let’s go shopping!
  </div>
  @endif
</div>
@endsection
