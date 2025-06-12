<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ $product->name_product }} - HandaiCoffee</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    :root {
      --primary-green: #0d9145;
      --secondary-green: #53ee77;
    }
  </style>
</head>

<body class="bg-gradient-to-b from-white to-green-50 text-gray-800 min-h-screen py-12">

  <!-- Container -->
  <div class="max-w-6xl mx-auto px-4">

    <!-- Box -->
    <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">

      <!-- Top Bar: Back & Cart -->
      <div class="flex justify-between items-center mb-8">
        <!-- Back -->
        <a href="{{ route('menu') }}"
           class="inline-flex items-center gap-1 text-[var(--primary-green)] hover:text-green-700 text-sm font-semibold transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          Back to Menu
        </a>

        <!-- Cart -->
        <a href="{{ route('cart.index') }}" class="relative block p-2 bg-white rounded-full shadow hover:shadow-md transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[var(--primary-green)] hover:text-green-700 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.35 2.7a1 1 0 00.9 1.3h12.3" />
          </svg>
          @php $cartCount = session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0; @endphp
          @if($cartCount > 0)
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
              {{ $cartCount }}
            </span>
          @endif
        </a>
      </div>

      <!-- Content -->
      <div class="grid md:grid-cols-2 gap-10 items-center">
        <!-- Image -->
        <div class="p-4">
          <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name_product }}"
               class="w-full h-[400px] object-contain rounded-xl shadow-md" />
        </div>

        <!-- Info -->
        <div>
          <h1 class="text-4xl font-bold text-[var(--primary-green)] mb-2">{{ $product->name_product }}</h1>
          <p class="text-2xl font-semibold text-gray-700 mb-4">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
          <p class="text-base text-gray-600 mb-6 leading-relaxed">{{ $product->description }}</p>

          <!-- Voucher Section -->
          @foreach ($vouchers as $voucher)
            <span class="
                text-sm font-bold px-3 py-1 rounded-full
                {{ $voucher->type === 'discount' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-700' }}">
                {{ $voucher->description }}
            </span>
        @endforeach


          <!-- Add to Cart -->
          <form action="{{ route('cart.add', $product->id_produk) }}" method="POST" class="flex items-center gap-2 mt-6">
            @csrf
            <button type="button" onclick="decreaseQty(this)" class="px-3 py-1 bg-gray-200 text-gray-700 rounded text-lg font-bold">−</button>
            <input type="number" name="quantity" value="1" min="1"
                   class="w-14 text-center border border-gray-300 rounded font-semibold text-sm" />
            <button type="button" onclick="increaseQty(this)" class="px-3 py-1 bg-gray-200 text-gray-700 rounded text-lg font-bold">+</button>
            <button type="submit"
                    class="ml-3 bg-[var(--primary-green)] text-white px-5 py-2 rounded-lg hover:bg-green-700 transition font-semibold text-sm">
              Add
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>

  <!-- JS -->
  <script>
    function increaseQty(button) {
      const input = button.parentElement.querySelector('input[name="quantity"]');
      let value = parseInt(input.value) || 1;
      input.value = value + 1;
    }

    function decreaseQty(button) {
      const input = button.parentElement.querySelector('input[name="quantity"]');
      let value = parseInt(input.value) || 1;
      if (value > 1) input.value = value - 1;
    }
  </script>
</body>
</html>
