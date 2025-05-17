<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - Handai Coffee</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --primary-green: #0d9145;
      --secondary-green: #53ee77;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-[var(--primary-green)] to-[var(--secondary-green)] text-white min-h-screen flex items-center justify-center">

  <!-- Register Form -->
  <div class="bg-white text-black rounded-lg shadow-lg p-8 w-full max-w-sm">
    <h2 class="text-3xl font-bold text-center mb-6">Register for Handai Coffee</h2>

    @if ($errors->any())
      <div class="mb-4 text-red-500">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <!-- Name -->
      <div class="mb-4">
        <label for="name" class="block text-sm font-semibold mb-2">Username</label>
        <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-green)]" placeholder="Enter your name">
      </div>

      <!-- Email -->
      <div class="mb-4">
        <label for="email" class="block text-sm font-semibold mb-2">Email</label>
        <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-green)]" placeholder="Enter your email">
      </div>


      <!-- Password -->
      <div class="mb-4">
        <label for="password" class="block text-sm font-semibold mb-2">Password</label>
        <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-green)]" placeholder="Enter your password">
      </div>

      <!-- Confirm Password -->
      <div class="mb-6">
        <label for="password_confirmation" class="block text-sm font-semibold mb-2">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-green)]" placeholder="Confirm your password">
      </div>

      <!-- Submit Button -->
      <button type="submit" class="w-full bg-[var(--primary-green)] hover:bg-green-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-[var(--secondary-green)]">
        Register
      </button>

      <!-- Login Link -->
      <div class="text-center mt-4">
        <p class="text-sm">Already have an account? <a href="{{ route('login') }}" class="text-[var(--primary-green)] hover:underline">Login here</a></p>
      </div>

      <!-- Back to Home Button -->
      <div class="text-center mt-6">
        <a href="/" class="inline-flex items-center text-[var(--primary-green)] hover:underline font-semibold">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
          </svg>
          Back to Home
        </a>
      </div>
    </form>
  </div>

</body>
</html>
