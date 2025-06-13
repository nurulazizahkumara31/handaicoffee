<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Handai Coffee Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Intro.js CDN -->
  <link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet">
  <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>

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
          <a href="/dashboard" class="hover:text-[var(--secondary-green)] transition">Home</a>
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
 

  <div id="chatBubble" 
     data-step="1" 
     data-intro="Kamu bisa ngobrol langsung dengan Handai di sini ya!" 
     class="fixed bottom-5 right-5 bg-green-700 text-white rounded-full w-14 h-14 flex items-center justify-center cursor-pointer shadow-lg">
  💬
</div>
  <div id="chatWindow" class="fixed bottom-20 right-5 bg-white w-80 max-h-96 rounded-lg shadow-lg p-4 hidden border border-green-200 z-[9999]">
    <div class="font-bold text-green-700 mb-2">Tanya Handai</div>
    <div id="chatMessages" class="text-sm mb-2 overflow-y-auto max-h-52 h-52 pr-1 space-y-2"></div>
    <input type="text" id="chatInput" placeholder="Ketik pertanyaan..." class="w-full border rounded px-2 py-1 text-sm">
  </div>

  <!-- Products Section -->
  <section id="products" class="bg-green-50 py-20">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-center mb-12">Our Signature Products</h2>
      <div class="grid md:grid-cols-3 gap-10">
        @foreach ($products as $product)
      <div class="bg-white text-[var(--primary-green)] rounded-xl shadow-lg overflow-hidden">
        <div class="flex justify-center items-center bg-white max-h-80 p-4">
          <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name_product }}" class="object-contain max-h-72 w-auto mx-auto">
        </div>
        <div class="p-6">
          <h3 class="text-xl font-bold text-[var(--primary-green)] mb-2">{{ $product->name_product }}</h3>
          <p class="mb-4">{{ $product->description }}</p>
          <a href="menu" class="bg-[var(--primary-green)] text-white px-4 py-2 rounded hover:bg-green-700">Order</a>
        </div>
      </div>
      @endforeach
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
  <!-- Background Music Player
  <audio id="background-music" loop preload="auto">
  <source src="{{ asset('audio/lagucafe.mp3') }}" type="audio/mpeg">
  Your browser does not support the audio element.
</audio> -->

<script>
  function openMusicPlayer() {
    const musicWindow = window.open(
      '/music-player', // ini halaman baru yang akan kita buat
      'HandaiMusic',
      'width=300,height=100,left=100,top=100'
    );
  }
</script>

<!-- Music Toggle Button -->
<button onclick="openMusicPlayer()" 
        data-step="2"
        data-intro="Klik tombol ini untuk menyalakan musik cafe 🎵"
        class="fixed bottom-5 left-5 bg-green-700 hover:bg-green-800 text-white p-3 rounded-full shadow-lg z-50">
  🎵
</button>


<!-- intro panduan -->
@if(Auth::user() && !Auth::user()->has_seen_intro)
<script>
  document.addEventListener('DOMContentLoaded', function () {
    introJs().start();
    fetch('/intro-seen', { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
  });
</script>
@endif

<script>
  const music = document.getElementById("background-music");
  const musicBtn = document.getElementById("music-btn");
  let isPlaying = false;

  function toggleMusic() {
    if (isPlaying) {
      music.pause();
      musicBtn.innerText = '🎵';
    } else {
      music.play().catch(() => alert("Klik dulu tombol ini untuk aktifkan musik 🎵"));
      musicBtn.innerText = '⏸️';
    }
    isPlaying = !isPlaying;
  }
</script>

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


    // Chatbot Logic
    const chatBubble = document.getElementById('chatBubble');
    const chatWindow = document.getElementById('chatWindow');
    const chatMessages = document.getElementById('chatMessages');
    const chatInput = document.getElementById('chatInput');

    chatBubble.addEventListener('click', () => {
      chatWindow.classList.toggle('hidden');
      chatInput.focus();
    });

    chatInput.addEventListener('keypress', async function (e) {
    if (e.key === 'Enter') {
      const message = chatInput.value.trim();
      if (!message) return;

      chatMessages.innerHTML += `<div><b>Kamu:</b> ${message}</div>`;

      // Tambahkan typing indicator
      chatMessages.innerHTML += `<div id="typing-indicator"><b>Handai:</b> <em>sedang mengetik...</em></div>`;
      chatInput.value = '';

      // Kirim ke API Gemini
      const res = await fetch('/api/chatbot', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ message })
      });

      const data = await res.json();

      // Hapus typing indicator
      const typingDiv = document.getElementById('typing-indicator');
      if (typingDiv) typingDiv.remove();

      // Tampilkan jawaban dari Gemini
      chatMessages.innerHTML += `<div><b>Handai:</b> ${data.reply}</div>`;
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }
  });

  </script>


</body>
</html>

