<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <title>Handai Coffee</title>
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
          <a href="" class="hover:text-[var(--secondary-green)] text-[var(--primary-green)]">Home</a>
          <a href="/menu" class="hover:text-[var(--secondary-green)] text-[var(--primary-green)]">Order</a>
          <a href="#" class="hover:text-[var(--secondary-green)] text-[var(--primary-green)]">About Us</a>
          <a href="#" class="hover:text-[var(--secondary-green)] text-[var(--primary-green)]">Contact</a>

          @auth
            <!-- Dropdown Menu -->
            <div class="relative">
              <button class="flex items-center space-x-2 px-4 py-2 border border-[var(--primary-green)] rounded hover:bg-[var(--secondary-green)] hover:text-white text-[var(--primary-green)]">
                <span class="text-sm">Hi, {{ Auth::user()->name }}</span>
                <!-- Ganti ikon menjadi ikon profil -->
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.31 0-6 2.69-6 6v2h12v-2c0-3.31-2.69-6-6-6z"/>
                </svg>
              </button>
              <div class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md text-[var(--primary-green)] hidden group-hover:block" id="dropdown-menu">
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
            <!-- Jika belum login -->
            <a href="/login" class="ml-4 px-4 py-2 border border-[var(--primary-green)] rounded hover:bg-[var(--secondary-green)] hover:text-white text-[var(--primary-green)]">Login</a>
          @endauth
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="container mx-auto px-4 py-12 flex flex-col md:flex-row items-center justify-between">
    <div class="md:w-1/2 mb-8 md:mb-0">
      <h1 class="text-4xl md:text-5xl font-bold mb-4 text-[var(--primary-green)]">Brewed Coffee for Your Soul</h1>
      <p class="mb-6 text-[var(--primary-green)]">
        At Handai Coffee, every sip tells a story. Enjoy a perfect blend of aroma, taste, and passion — from beans to your cup.
      </p>
      <a href="#products" class="bg-[var(--primary-green)] hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
        Order Now
      </a>
    </div>
    <div class="md:w-1/2 text-center">
      <img src="images/53878199057.png" alt="Coffee Product" class="mx-auto max-h-80">
    </div>
  </section>

  <!-- Products Section -->
  <section id="products" class="container mx-auto px-4 py-12">
    <h2 class="text-3xl font-bold text-center mb-10 text-[var(--primary-green)]">Our Signature Products</h2>
    <div class="grid md:grid-cols-3 gap-8">
      <!-- Product 1 -->
      <div class="bg-white text-[var(--primary-green)] rounded-xl shadow-lg overflow-hidden">
        <div class="flex justify-center items-center bg-white max-h-80 p-4">
          <img src="images/susukurma.png" alt="Susu Kurma" class="object-contain max-h-72 w-auto mx-auto">
        </div>
        <div class="p-6">
          <h3 class="text-xl font-bold text-[var(--primary-green)] mb-2">Susu Kurma</h3>
          <p class="mb-4">Perpaduan susu segar dan kurma asli, minuman sehat dan nikmat yang cocok untuk semua kalangan.</p>
          <a href="menu.html" class="bg-[var(--primary-green)] text-white px-4 py-2 rounded hover:bg-green-700">Order</a>
        </div>
      </div>

      <!-- Product 2 -->
      <div class="bg-white text-[var(--primary-green)] rounded-xl shadow-lg overflow-hidden">
        <div class="flex justify-center items-center bg-white max-h-80 p-4">
          <img src="images/kopisusu.png" alt="Kopi Susu" class="object-contain max-h-72 w-auto mx-auto">
        </div>
        <div class="p-6">
          <h3 class="text-xl font-bold text-[var(--primary-green)] mb-2">Kopi Susu Gula Aren</h3>
          <p class="mb-4">Kombinasi espresso dan susu segar yang lembut, cocok untuk menemani harimu.</p>
          <a href="menu.html" class="bg-[var(--primary-green)] text-white px-4 py-2 rounded hover:bg-green-700">Order</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-4 bg-white text-[var(--primary-green)] border-t border-[var(--primary-green)]">
    <p>&copy; 2025 Handai Coffee. All Rights Reserved.</p>
  </footer>

  <!-- Toggle Script -->
  <script>
    const menuBtn = document.getElementById("menu-button");
    const mobileMenu = document.getElementById("mobile-menu");
    menuBtn.addEventListener("click", () => {
      mobileMenu.classList.toggle("hidden");
    });

    // For Dropdown Menu
    const dropdownBtn = document.querySelector('.relative');
    dropdownBtn.addEventListener('click', () => {
      const dropdownMenu = dropdownBtn.querySelector('#dropdown-menu');
      dropdownMenu.classList.toggle('hidden');
    });
  </script>

</body>
</html>
