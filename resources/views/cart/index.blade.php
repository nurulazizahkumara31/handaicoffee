@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">

  <!-- Back Button -->
  <a href="/menu" class="inline-flex items-center text-sm text-green-600 hover:underline mb-6">
    ← Back to Menu
  </a>

  <h2 class="text-2xl font-bold text-center text-green-700 mb-8">🛒 Your Cart</h2>

  @if (count($cart) > 0)
  @php 
    $total = 0; 
    $shipping = 5000; 
  @endphp

  <!-- Cart List -->
  <!-- Cart List -->
<div class="space-y-4" id="cart-list">
  @foreach ($cart as $id => $item)
    @php 
      $subtotal = $item['price'] * $item['quantity']; 
      $total += $subtotal;
    @endphp
    <div class="flex flex-wrap items-center justify-between border p-4 rounded-lg bg-white shadow-sm" data-item-id="{{ $id }}">
      <div class="flex items-center gap-4 w-full sm:w-auto">
        <img src="{{ asset('storage/' . $item['image']) }}" class="w-14 h-14 object-cover rounded border" alt="{{ $item['name'] }}">

        <div>
          <h4 class="font-medium text-gray-800">{{ $item['name'] }}</h4>
          <p class="text-sm text-gray-500">Qty: 
            <input type="number" name="quantity[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" class="w-16 p-2 border rounded">
          </p>
        </div>
      </div>
      <div class="flex items-center justify-between mt-4 sm:mt-0 w-full sm:w-auto gap-4">
        <span class="font-semibold text-gray-700 subtotal" data-item-id="{{ $id }}">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>

        <!-- Delete Button -->
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
  <div class="bg-gray-50 p-4 rounded-lg shadow-inner space-y-2 text-sm text-gray-700">
    <div class="flex justify-between">
      <span>Subtotal</span>
      <span id="subtotal">Rp{{ number_format($total, 0, ',', '.') }}</span>
    </div>
    <div class="flex justify-between">
      <span>Shipping</span>
      <span>Rp{{ number_format($shipping, 0, ',', '.') }}</span>
    </div>
    <div class="flex justify-between font-semibold text-lg border-t pt-2">
      <span>Total</span>
      <span id="total" class="text-green-700">Rp{{ number_format($total + $shipping, 0, ',', '.') }}</span>
    </div>
  </div>
  <form action="{{ route('cart.checkout') }}" method="POST" class="text-center mt-6">
    @csrf
    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
        Checkout
    </button>
</form>

  @else
  <div class="text-center text-gray-500 mt-12">
    Your cart is empty.
  </div>
  @endif
</div>
@endsection
