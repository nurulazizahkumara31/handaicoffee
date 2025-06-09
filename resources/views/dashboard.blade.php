<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Handai Coffee Dashboard</title>
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
<body class="bg-gradient-to-b from-green-50 to-white text-[var(--primary-green)] min-h-screen">

  <!-- Navbar -->
  <nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <a href="/" class="flex items-center space-x-2">
          <img src="{{ asset('images/logocoffee2.png') }}" alt="Handai Coffee Logo" class="h-10 w-auto">
        </a>
        <div class="hidden md:flex space-x-6 items-center text-sm font-medium">
          <a href="/" class="hover:text-[var(--secondary-green)] transition">Home</a>
          <a href="/menu" class="hover:text-[var(--secondary-green)] transition">Order</a>
          <a href="/about" class="hover:text-[var(--secondary-green)] transition">About Us</a>
          <a href="/contact" class="hover:text-[var(--secondary-green)] transition">Contact</a>

          @auth
          <div class="relative group">
            <button class="flex items-center px-4 py-2 border border-[var(--primary-green)] rounded-full hover:bg-[var(--secondary-green)] hover:text-white transition">
              <span class="text-sm">Hi, {{ Auth::user()->name }}</span>
              <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-3.31 0-6 2.69-6 6v2h12v-2c0-3.31-2.69-6-6-6z"/>
              </svg>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded hidden group-hover:block">
              <a href="/profile" class="block px-4 py-2 text-sm">Profil</a>
              <a href="/order_history" class="block px-4 py-2 text-sm">Order History</a>
              <a href="/settings" class="block px-4 py-2 text-sm">Settings</a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-500 font-bold">Logout</button>
              </form>
            </div>
          </div>
          @else
          <a href="/login" class="px-4 py-2 border border-[var(--primary-green)] rounded-full hover:bg-[var(--secondary-green)] hover:text-white transition">Login</a>
          @endauth
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="bg-white py-20">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
      <div class="md:w-1/2 animate-fade-in-up">
        <h1 class="text-5xl font-extrabold mb-6 leading-tight">Brewed Coffee for Your Soul</h1>
        <p class="mb-6 text-lg leading-relaxed text-gray-700">
          Nikmati aroma dan rasa khas dari biji pilihan hingga ke cangkir Anda.<br>
          Coba varian favorit: <strong>Susu Kurma</strong> yang manis alami & <strong>Kopi Susu Gula Aren</strong> yang klasik.
        </p>
        <a href="/login" class="inline-block bg-[var(--primary-green)] hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full transition-all">Order Now</a>
      </div>
      <div class="md:w-1/2 mt-10 md:mt-0 text-center">
        <img src="{{ asset('images/mockupdash.png') }}" alt="Coffee Product" class="w-full max-w-md mx-auto rounded-xl shadow-xl">
      </div>
    </div>
  </section>

  <!-- Products Section -->
  <section id="products" class="bg-green-50 py-20">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-center mb-12">Our Signature Products</h2>
      <div class="grid md:grid-cols-3 gap-10">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden transform hover:scale-105 transition">
          <img src="images/susukurma.png" alt="Susu Kurma" class="w-full h-60 object-contain p-6">
          <div class="p-6">
            <h3 class="text-xl font-bold mb-2">Susu Kurma</h3>
            <p class="mb-4 text-sm text-gray-600">Susu segar + kurma asli, minuman sehat & nikmat untuk semua kalangan.</p>
            <a href="/menu" class="inline-block bg-[var(--primary-green)] text-white px-4 py-2 rounded-full hover:bg-green-700">Order</a>
          </div>
        </div>
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden transform hover:scale-105 transition">
          <img src="images/kopisusu.png" alt="Kopi Susu Gula Aren" class="w-full h-60 object-contain p-6">
          <div class="p-6">
            <h3 class="text-xl font-bold mb-2">Kopi Susu Gula Aren</h3>
            <p class="mb-4 text-sm text-gray-600">Espresso + susu segar dengan cita rasa kaya dan khas Indonesia.</p>
            <a href="/menu" class="inline-block bg-[var(--primary-green)] text-white px-4 py-2 rounded-full hover:bg-green-700">Order</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- News Section -->
  <section id="news" class="bg-white py-20">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-center mb-12">Berita Seputar Kopi</h2>
      <div id="news-container" class="grid md:grid-cols-2 gap-8"></div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-[var(--primary-green)] text-white py-6">
    <p class="text-center text-sm">&copy; 2025 Handai Coffee. All Rights Reserved.</p>
  </footer>

  <!-- Script: Dropdown & Fetch News -->
  <script>
    document.getElementById("menu-button")?.addEventListener("click", () => {
      document.getElementById("mobile-menu")?.classList.toggle("hidden");
    });
    const dropdownBtn = document.querySelector('.relative');
    dropdownBtn?.addEventListener('click', () => {
      dropdownBtn.querySelector('#dropdown-menu')?.classList.toggle('hidden');
    });

    async function fetchNews() {
      const url = '/api/news';
      try {
        const response = await fetch(url);
        const data = await response.json();
        const newsContainer = document.getElementById('news-container');
        if (data.articles && data.articles.length > 0) {
          data.articles.slice(0, 4).forEach(article => {
            const html = `
              <div class="bg-white shadow-md rounded-lg overflow-hidden transition hover:shadow-xl">
                <img src="${article.urlToImage || 'https://via.placeholder.com/400x200'}" class="w-full h-48 object-cover">
                <div class="p-4">
                  <h3 class="text-lg font-bold mb-2 text-[var(--primary-green)]">${article.title}</h3>
                  <p class="text-sm mb-2 text-gray-700">${article.description || ''}</p>
                  <a href="${article.url}" target="_blank" class="text-[var(--primary-green)] hover:text-[var(--secondary-green)] text-sm font-semibold">Baca Selengkapnya</a>
                </div>
              </div>
            `;
            newsContainer.innerHTML += html;
          });
        } else {
          newsContainer.innerHTML = '<p class="text-center text-gray-500">Tidak ada berita ditemukan.</p>';
        }
      } catch (err) {
        console.error(err);
        document.getElementById('news-container').innerHTML = '<p class="text-center text-red-500">Gagal memuat berita.</p>';
      }
    }
    document.addEventListener('DOMContentLoaded', fetchNews);
  </script>

</body>
</html>

