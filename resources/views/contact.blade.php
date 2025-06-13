<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }
    :root {
      --primary-green: #0d9145;
      --secondary-green: #53ee77;
    }
  </style>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact Us - Handai Coffee</title>
  <style>
    :root {
      --primary-green: #0d9145;
      --secondary-green: #53ee77;
    }
  </style>
</head>
<body class="bg-white text-[var(--primary-green)] min-h-screen flex flex-col">

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

  <!-- Contact Section -->
  <section class="max-w-7xl mx-auto px-4 py-16 flex-grow">
    <h1 class="text-4xl font-bold text-center mb-8">Contact Us</h1>
    <div class="md:flex md:items-start md:space-x-10">
      <div class="md:w-1/2 mb-8 md:mb-0">
        <img src="{{asset('images/mockupdash.png') }}" alt="Contact Handai Coffee" class="rounded-xl shadow-md w-full">
      </div>
      <div class="md:w-1/2">
        <p class="mb-4 text-lg leading-relaxed">
          Ada pertanyaan, kritik, atau saran? Kami senang mendengarnya! Silakan hubungi kami melalui informasi kontak di bawah atau isi formulir kontak.
        </p>
        <ul class="mb-4 text-lg space-y-2">
          <li><strong>Email:</strong> info@handaicoffee.com</li>
          <li><strong>Telepon:</strong> +62 812-3456-7890</li>
          <li><strong>Alamat:</strong> Jl. Kopi No. 1, Bandung, Indonesia</li>
        </ul>
        <a href="https://www.instagram.com/handaicoffee/" class="inline-block mt-4 bg-[var(--primary-green)] text-white px-6 py-2 rounded hover:bg-green-700">Lihat Instagram</a>
      </div>
    </div>
  </section>

<!-- Footer -->
<footer class="bg-[var(--primary-green)] text-white py-6">
    <p class="text-center text-sm">&copy; 2025 Handai Coffee. All Rights Reserved.</p>
  </footer>


  <!-- Toggle Scripts -->
  <script>
    const menuBtn = document.getElementById("menu-button");
    const navMenu = document.getElementById("nav-menu");
    const userBtn = document.getElementById("user-button");
    const dropdownMenu = document.getElementById("dropdown-menu");

    menuBtn?.addEventListener("click", () => {
      navMenu?.classList.toggle("hidden");
    });

    userBtn?.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdownMenu?.classList.toggle("hidden");
    });

    document.addEventListener("click", (e) => {
      if (!document.getElementById("user-menu")?.contains(e.target)) {
        dropdownMenu?.classList.add("hidden");
      }
    });
  </script>

</body>
</html>
