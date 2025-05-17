<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Handai Coffee</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-white text-[var(--primary-green)] min-h-screen">
  <div class="container mx-auto px-4 py-8">
    @yield('content')
  </div>
</body>
</html>
