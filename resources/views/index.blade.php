<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Handai Coffee</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --primary-green: #0d9145;
      --secondary-green: #53ee77;
    }
    body {
      font-family: 'Poppins', sans-serif;
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
        <div class="hidden md:flex space-x-6 items-center">
          <a href="/" class="hover:text-[var(--secondary-green)] font-bold">Home</a>
          <a href="/login" class="hover:text-[var(--secondary-green)]">Order</a>
          <a href="/about" class="hover:text-[var(--secondary-green)]">About Us</a>
          <a href="/contact" class="hover:text-[var(--secondary-green)]">Contact</a>
          <a href="/login" class="ml-4 px-4 py-2 border border-[var(--primary-green)] rounded hover:bg-[var(--secondary-green)] hover:text-white">Login</a>
        </div>
      </div>
    </div>
  </nav>
  <!-- Nurul -->
  <!-- Hero Section -->
  <section class="container mx-auto px-4 py-16 flex flex-col md:flex-row items-center justify-between">
    <div class="md:w-1/2 mb-8 md:mb-0">
      <h1 class="text-5xl font-extrabold mb-6 leading-tight">Brewed Coffee for Your Soul</h1>
      <p class="mb-6 text-gray-700 text-lg">
        Boost Your Study, Sustain Your Health!.<br>
        Nikmati perpaduan aroma dan rasa yang khas dari biji pilihan hingga ke cangkir Anda.<br><br>
        Coba varian favorit kami, <strong>Susu Kurma</strong> yang manis alami dan menyegarkan atau <strong>Kopi Susu Gula Aren</strong> yang klasik dan autentik.
      </p>
      <a href="/login" class="inline-block bg-[var(--primary-green)] hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full transition-all">Order Now</a>
    </div>
    <div class="md:w-1/2 text-center">
      <img src="{{ asset('images/mockupdash.png') }}" alt="Coffee Product" class="mx-auto w-full max-w-[550px] rounded-xl shadow-xl">
    </div>
  </section>

  <!-- Products Section -->
  <section id="products" class="bg-green-50 py-20">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-12">Our Signature Products</h2>
      <div class="grid md:grid-cols-3 gap-10">
        @forelse ($products as $product)
          <div class="bg-white text-[var(--primary-green)] rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="flex justify-center items-center bg-white max-h-80 p-4">
              <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name_product }}" class="object-contain max-h-72 w-auto mx-auto">
            </div>
            <div class="p-6">
              <h3 class="text-2xl font-bold mb-2">{{ $product->name_product }}</h3>
              <p class="mb-4 text-sm text-gray-700">{{ $product->description }}</p>
              <a href="/product/{{ $product->id }}" class="bg-[var(--primary-green)] text-white px-4 py-2 rounded-full hover:bg-green-700 font-semibold">Order</a>
            </div>
          </div>
        @empty
          <p class="text-center col-span-3 text-gray-500">Produk belum tersedia.</p>
        @endforelse
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-[var(--primary-green)] text-white py-6">
    <p class="text-center text-sm">&copy; 2025 Handai Coffee. All Rights Reserved.</p>
  </footer>

</body>
</html>