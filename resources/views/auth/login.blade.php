<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - Handai Coffee</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
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
<body class="bg-gradient-to-br from-[var(--primary-green)] to-[var(--secondary-green)] text-white min-h-screen flex items-center justify-center px-4">

  <!-- Login Container -->
  <div class="bg-white text-gray-800 rounded-2xl shadow-2xl px-8 py-10 max-w-md w-full border-4 border-transparent hover:border-[var(--primary-green)] transition duration-300">
    <h2 class="text-3xl font-extrabold text-center text-[var(--primary-green)] mb-6">Login</h2>
    <p class="text-center text-sm text-gray-500 mb-6">Login to your Handai Coffee account</p>

    @if ($errors->any())
      <div class="mb-4 text-red-500 text-sm">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
      @csrf

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium mb-1">Email</label>
        <input type="email" id="email" name="email" required placeholder="you@email.com"
          class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[var(--primary-green)] transition">
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-sm font-medium mb-1">Password</label>
        <input type="password" id="password" name="password" required placeholder="••••••••"
          class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[var(--primary-green)] transition">
      </div>

      <!-- Login Button -->
      <div>
        <button type="submit"
          class="w-full bg-[var(--primary-green)] hover:bg-green-800 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
          Login
        </button>
      </div>
    </form>

    <!-- Forgot Password -->
    <div class="text-right mt-2">
      <a href="#" class="text-sm text-[var(--primary-green)] hover:underline">Forgot password?</a>
    </div>

    <!-- Register -->
    <div class="text-center mt-6">
      <p class="text-sm">Don't have an account? 
        <a href="/register" class="text-[var(--primary-green)] font-medium hover:underline">Register now</a>
      </p>
    </div>

    <!-- Back to Home -->
    <div class="text-center mt-6">
      <a href="/" class="inline-flex items-center text-[var(--primary-green)] hover:underline font-medium">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Home
      </a>
    </div>
  </div>

</body>
</html>
