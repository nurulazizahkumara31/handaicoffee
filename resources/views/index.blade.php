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
  <nav class="bg-white shadow-lg sticky top-0 z-50">
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
        <div id="mobile-menu" class="hidden md:flex space-x-6 items-center">
          <a href="/" class="hover:text-[var(--secondary-green)] text-[var(--primary-green)] font-bold">Home</a>
          <a href="/login" class="hover:text-[var(--secondary-green)] text-[var(--primary-green)]">Order</a>
          <a href="/about" class="hover:text-[var(--secondary-green)] text-[var(--primary-green)]">About Us</a>
          <a href="/contact" class="hover:text-[var(--secondary-green)] text-[var(--primary-green)]">Contact</a>
          <a href="/login" class="ml-4 px-4 py-2 border border-[var(--primary-green)] rounded hover:bg-[var(--secondary-green)] hover:text-white text-[var(--primary-green)]">Login</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="container mx-auto px-4 py-12 flex flex-col md:flex-row items-center justify-between">
    <div class="md:w-1/2 mb-8 md:mb-0">
      <h1 class="text-4xl md:text-5xl font-bold mb-5 text-[var(--primary-green)]">Brewed Coffee for Your Soul</h1>
        <p class="mb-3">
        At Handai Coffee, every sip tells a story.<br>
          Nikmati perpaduan aroma dan rasa yang khas dari biji pilihan hingga ke cangkir Anda. 
          <br> <br> Coba varian favorit kami, Susu Kurma yang manis alami dan menyegarkan atau Kopi Susu Gula Aren dengan rasa klasik yang kaya dan autentik. 
        </p>
      <a href="/login" class="mt-10 inline-block bg-[var(--primary-green)] hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
        Order Now
      </a>
    </div>
    <div class="md:w-1/2 text-center">
    <img src="{{ asset('images/mockupdash.png') }}" alt="Coffee Product" class="mx-auto w-[100%] md:w-[100%] max-w-[550px]">

    </div>
  </section>

  <!-- Products Section -->
  <section id="products" class="container mx-auto px-4 py-12">
    <h2 class="text-3xl font-bold text-center mb-10">Our Signature Products</h2>
    <div class="grid md:grid-cols-3 gap-8">

      <!-- Product 1 -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="flex justify-center items-center bg-white max-h-80 p-4">
          <img src="images/susukurma.png" alt="Susu Kurma" class="object-contain max-h-72 w-auto mx-auto">
        </div>
        <div class="p-6">
          <h3 class="text-xl font-bold mb-2">Susu Kurma</h3>
          <p class="mb-4">Perpaduan susu segar dan kurma asli, minuman sehat dan nikmat yang cocok untuk semua kalangan.</p>
          <a href="/login" class="bg-[var(--primary-green)] text-white px-4 py-2 rounded hover:bg-green-700">Order</a>
        </div>
      </div>

      <!-- Product 2 -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="flex justify-center items-center bg-white max-h-80 p-4">
          <img src="images/kopisusu.png" alt="Kopi Susu" class="object-contain max-h-72 w-auto mx-auto">
        </div>
        <div class="p-6">
          <h3 class="text-xl font-bold mb-2">Kopi Susu Gula Aren</h3>
          <p class="mb-4">Kombinasi espresso dan susu segar yang lembut, cocok untuk menemani harimu.</p>
          <a href="/login" class="bg-[var(--primary-green)] text-white px-4 py-2 rounded hover:bg-green-700">Order</a>
        </div>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-4 bg-white border-t border-[var(--primary-green)]">
    <p>&copy; 2025 Handai Coffee. All Rights Reserved.</p>
  </footer>

  <!-- Toggle Script -->
  <script>
    const menuBtn = document.getElementById("menu-button");
    const mobileMenu = document.getElementById("mobile-menu");
    menuBtn.addEventListener("click", () => {
      mobileMenu.classList.toggle("hidden");
    });
  </script>

</body>
</html>
