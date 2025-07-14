<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hadegold Media- Music Distribution</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900 font-sans">
  <!-- Header -->
  <header class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-xl font-bold text-indigo-600">🎧 Distro</h1>
      @if (Route::has('login'))
      <nav class="space-x-6">
      <a href="#" class="hover:text-indigo-600">Home</a>
      <a href="#" class="hover:text-indigo-600">Features</a>
      <a href="#" class="hover:text-indigo-600">Pricing</a>
      <a href="#" class="hover:text-indigo-600">Contact</a>
      @auth
      <a href="{{ url('/dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
      @else
      <a href="{{ route('login') }}" class="hover:text-indigo-600">Log in</a>@if (Route::has('register'))
      <a
        href="{{ route('register') }}"
        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
        Register
      </a>
    @endif

      @endauth
      </nav>
    @endif
    </div>
  </header>

  <!-- Hero -->
  <section class="text-center py-20 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
    <div class="max-w-3xl mx-auto px-6">
      <h2 class="text-4xl font-extrabold mb-4">Distribute Your Music. Keep 100% of Your Rights.</h2>
      <p class="text-lg mb-6">Upload once. Get on Spotify, Apple Music, and more. Simple. Fast. Reliable.</p>
      <a href="#" class="bg-white text-indigo-600 px-6 py-3 rounded-full font-medium hover:bg-gray-100 transition">Get
        Started</a>
    </div>
  </section>

  <!-- Features -->
  <section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <h3 class="text-2xl font-bold mb-10">Why Use Distro?</h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="p-6 border rounded-lg shadow hover:shadow-lg transition">
          <h4 class="font-bold text-lg mb-2">Global Reach</h4>
          <p>Distribute your music to over 150+ platforms worldwide.</p>
        </div>
        <div class="p-6 border rounded-lg shadow hover:shadow-lg transition">
          <h4 class="font-bold text-lg mb-2">Full Control</h4>
          <p>Keep all rights to your music and access powerful analytics.</p>
        </div>
        <div class="p-6 border rounded-lg shadow hover:shadow-lg transition">
          <h4 class="font-bold text-lg mb-2">Fast Payouts</h4>
          <p>Get your earnings quickly with our secure payout system.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white text-center py-6">
    <p>&copy; {{ now()->year }} Hadegold Media. All rights reserved.</p>
  </footer>

</body>

</html>