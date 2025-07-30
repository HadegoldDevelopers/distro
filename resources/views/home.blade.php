<!DOCTYPE html>
<html="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Hadegold Media - Music Distribution</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900 font-sans">

  <!-- Header -->
  <header class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <img src="{{ asset('storage/' .'logo/distro-goldd.png') }}" alt="Distro Gold logo" class="w-10 h-10 mr-2">

      @if (Route::has('login'))
      <nav class="space-x-6">
        <a href="#" class="hover:text-indigo-600">Home</a>
        <a href="#" class="hover:text-indigo-600">Features</a>
        <a href="#" class="hover:text-indigo-600">Pricing</a>
        <a href="#" class="hover:text-indigo-600">Contact</a>

        @auth
        <a href="{{ url('/dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
        @else
        <a href="{{ route('login') }}" class="hover:text-indigo-600">Log in</a>
        @if (Route::has('register'))
        <a href="{{ route('register') }}"
          class="inline-block px-5 py-1.5 border text-sm rounded-sm text-[#1b1b18] hover:border-indigo-300 transition">
          Register
        </a>
        @endif
        @endauth
      </nav>
      @endif
    </div>
  </header>

  <!-- Hero -->
  <section class="relative h-screen flex items-center justify-center text-center text-white bg-cover bg-center" 
         style="background-image: url('/images/music-bg.jpg')">
  
  <!-- Overlay with brand color and opacity -->
  <div class="absolute inset-0 bg-[#0B194E]/80"></div>

  <!-- Content -->
  <div class="relative z-10 max-w-3xl mx-auto px-6">
    <h2 class="text-4xl md:text-5xl font-extrabold mb-4">Distribute Your Music. Keep 100% of Your Rights.</h2>
    <p class="text-lg mb-6">Upload once. Get on Spotify, Apple Music, and more. Simple. Fast. Reliable.</p>
    <a href="#" class="bg-white text-[#0B194E] px-6 py-3 rounded-full font-medium hover:bg-gray-100 transition">
      Get Started
    </a>
  </div>
</section>


  <!-- How It Works -->
  <section class="py-16 bg-gray-50" id="how-it-works">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <h3 class="text-2xl font-bold mb-10">How It Works</h3>
      <div class="grid md:grid-cols-3 gap-8">
        <div>
          <h4 class="text-lg font-semibold mb-2">1. Upload Your Music</h4>
          <p class="text-gray-600">Drag and drop your songs, cover art, and metadata. Done in minutes.</p>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-2">2. We Distribute It</h4>
          <p class="text-gray-600">We deliver your music to Spotify, Apple Music, YouTube, TikTok, and more.</p>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-2">3. You Get Paid</h4>
          <p class="text-gray-600">Track your royalties and get fast payouts with no hidden fees.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Pricing -->
  <section class="py-16 bg-white text-center">
    <div class="max-w-xl mx-auto px-6">
      <h3 class="text-2xl font-bold mb-4">Simple, Transparent Pricing</h3>
      <p class="text-gray-600 mb-6">One flat rate. No hidden fees. No revenue split.</p>
      <div class="inline-block bg-gray-100 p-8 rounded-lg shadow">
        <h4 class="text-3xl font-bold mb-2">$19.99/year</h4>
        <p class="mb-4 text-gray-700">Unlimited uploads, full control, instant payouts.</p>
        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-full font-semibold">
          Start Free Trial
        </a>
      </div>
    </div>
  </section>

  <!-- Fullscreen Hero with background image -->
  <section id="hero" class="relative h-screen flex items-center justify-center text-center bg-cover bg-center"
    style="background-image:url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQF5HKsopY1Cb58ETan7LqHDr1R5nOb7Grvrg&s')">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative z-10 px-6 max-w-2xl">
      <h1 class="text-5xl md:text-6xl font-bold mb-4">Ship Your Music Worldwide</h1>
      <p class="text-lg mb-8">Fast, affordable, and artist-first music distribution.</p>
      <a href="{{ route('register') }}"
        class="inline-block bg-indigo-500 hover:bg-indigo-400 px-8 py-3 rounded-full text-xl font-semibold transition">Start
        Free</a>
    </div>
  </section>

  <!-- Partners -->
  <section class="py-12 bg-gray-800">
    <div class="max-w-6xl mx-auto flex flex-wrap justify-center gap-8 opacity-70">
      <img src="/images/spotify-logo-white.svg" alt="Spotify" class="h-8 grayscale hover:opacity-100 transition" />
      <img src="/images/apple-music-white.svg" alt="Apple Music" class="h-8 grayscale hover:opacity-100 transition" />
      <img src="/images/tiktok-logo-white.svg" alt="TikTok" class="h-8 grayscale hover:opacity-100 transition" />
      <img src="/images/youtube-logo-white.svg" alt="YouTube" class="h-8 grayscale hover:opacity-100 transition" />
    </div>
  </section>

  <!-- About + Features -->
  <section id="features" class="py-20 bg-gray-900 text-gray-100">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
      <div class="space-y-6">
        <h2 class="text-4xl font-bold">Why Choose Us?</h2>
        <p class="text-gray-400">Keep 100% of your royalties, distribute to every major platform, and get paid quickly—no
          hidden fees.</p>
        <a href="#how-it-works" class="text-indigo-400 underline hover:text-indigo-300 transition">See how it works
          →</a>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        @foreach ([
          ['Upload Easily', 'Drag & drop your audio, art, and metadata.'],
          ['Wide Distribution', 'Spotify • Apple Music • TikTok • YouTube & more.'],
          ['Artist Dashboard', 'Analytics, earnings, and growth tools.'],
          ['Fast Payouts', 'Withdraw earnings monthly with ease.'],
        ] as $feature)
          <div class="p-6 bg-gray-800 rounded-xl hover:bg-gray-700 transition">
            <h3 class="text-xl font-semibold mb-2">{{ $feature[0] }}</h3>
            <p class="text-gray-400">{{ $feature[1] }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- CTA Banner -->
  <section class="py-16 bg-indigo-500 text-center text-white">
    <div class="max-w-3xl mx-auto px-6">
      <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Launch Your Music?</h2>
      <a href="{{ route('register') }}"
        class="inline-block bg-white text-indigo-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition">Start
        Free Today</a>
    </div>
  </section>

  <!-- Why Use Distro? -->
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
    <div class="flex justify-center space-x-6 mt-4">
      <a href="#" class="hover:text-indigo-400">Privacy</a>
      <a href="#" class="hover:text-indigo-400">Terms</a>
      <a href="#" class="hover:text-indigo-400">Contact</a>
    </div>
  </footer>

</body>

</html=>
