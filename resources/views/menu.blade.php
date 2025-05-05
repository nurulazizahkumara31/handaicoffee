<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Handai Coffee - Order Menu</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --primary-green: #0d9145;
      --secondary-green: #53ee77;
    }
  </style>
</head>
<body class="bg-white text-[var(--primary-green)] min-h-screen">

  <!-- Navbar -->
  <nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <a href="/" class="flex items-center space-x-2">
          <img src="{{ asset('images/logocoffee2.png') }}" alt="Handai Coffee Logo" class="h-10 w-auto">
        </a>

        <!-- Mobile button -->
        <div class="md:hidden">
          <button id="menu-button" class="text-[var(--primary-green)] focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>

        <!-- Menu -->
        <div class="hidden md:flex space-x-6 items-center">
          <a href="/dashboard" class="hover:text-[var(--secondary-green)] text-[var(--primary-green)]">Home</a>
          <a href="/menu" class="hover:text-[var(--secondary-green)] text-[var(--primary-green)]">Order</a>
          <a href="#" class="hover:text-[var(--secondary-green)] text-[var(--primary-green)]">About Us</a>
          <a href="#" class="hover:text-[var(--secondary-green)] text-[var(--primary-green)]">Contact</a>

          @auth
            <!-- Dropdown Menu -->
            <div class="relative">
              <button class="flex items-center space-x-2 px-4 py-2 border border-[var(--primary-green)] rounded hover:bg-[var(--secondary-green)] hover:text-white text-[var(--primary-green)]">
                <span class="text-sm">Hi, {{ Auth::user()->name }}</span>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.31 0-6 2.69-6 6v2h12v-2c0-3.31-2.69-6-6-6z"/>
                </svg>
              </button>
              <div class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md text-[var(--primary-green)] hidden" id="dropdown-menu">
                <a href="/profile" class="block px-4 py-2 text-sm">Profil</a>
                <a href="#" class="block px-4 py-2 text-sm">Order History</a>
                <a href="#" class="block px-4 py-2 text-sm">Settings</a>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-500 font-bold">Logout</button>
                </form>
              </div>
            </div>
          @else
            <a href="/login" class="ml-4 px-4 py-2 border border-[var(--primary-green)] rounded hover:bg-[var(--secondary-green)] hover:text-white text-[var(--primary-green)]">Login</a>
          @endauth
        </div>
      </div>
    </div>
  </nav>

<!-- Floating Cart Icon -->
<div class="fixed top-20 right-4 z-50">
  <a href="{{ route('cart.index') }}" class="relative">
    <!-- Cart Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[var(--primary-green)] hover:text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.35 2.7a1 1 0 00.9 1.3h12.3" />
    </svg>

    <!-- Badge item count -->
    @php
      $cartCount = session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0;
    @endphp
    @if($cartCount > 0)
    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
      {{ $cartCount }}
    </span>
    @endif
  </a>
</div>


  <!-- Menu Section -->
  <section class="container mx-auto px-4 py-12">
    <h2 class="text-3xl font-bold text-center mb-10 text-[var(--primary-green)]">Choose Your Coffee</h2>

    <div class="grid md:grid-cols-3 sm:grid-cols-1 gap-8">
      @foreach ($products as $product)
      <div class="bg-white text-[var(--primary-green)] rounded-xl shadow-lg overflow-hidden">
        <div class="flex justify-center items-center bg-white max-h-80 p-4">
          <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name_product }}" class="object-contain max-h-72 w-auto mx-auto">
        </div>
        <div class="p-6">
          <h3 class="text-xl font-bold mb-2">{{ $product->name_product }}</h3>
          <p class="text-lg mb-2 font-semibold">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
          <p class="text-sm text-gray-700 mb-4">{{ $product->description }}</p>

          <a href="{{ route('product.show', $product->id_produk) }}" class="text-[var(--primary-green)] underline text-sm hover:text-green-700 mb-2 inline-block">View Details</a>

          <form action="{{ route('cart.add', $product->id_produk) }}" method="POST" class="flex items-center gap-2 mt-2">
            @csrf
            <button type="button" onclick="decreaseQty(this)" class="px-3 py-1 bg-gray-200 text-gray-700 rounded">-</button>
            <input type="number" name="quantity" value="1" min="1" class="w-12 text-center border border-gray-300 rounded" />
            <button type="button" onclick="increaseQty(this)" class="px-3 py-1 bg-gray-200 text-gray-700 rounded">+</button>
            <button type="submit" class="ml-auto bg-[var(--primary-green)] text-white px-4 py-1 rounded hover:bg-green-700">Add</button>
          </form>
        </div>
      </div>
      @endforeach
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-4 bg-white text-[var(--primary-green)] border-t border-[var(--primary-green)]">
    <p>&copy; 2025 Handai Coffee. All Rights Reserved.</p>
  </footer>

  <!-- Scripts -->
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

    document.addEventListener("DOMContentLoaded", () => {
      const dropdownBtn = document.querySelector('.relative > button');
      if (dropdownBtn) {
        dropdownBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          const menu = document.getElementById('dropdown-menu');
          if (menu) menu.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
          const menu = document.getElementById('dropdown-menu');
          if (menu && !menu.classList.contains('hidden')) {
            menu.classList.add('hidden');
          }
        });
      }
    });
  </script>
</body>
</html>
