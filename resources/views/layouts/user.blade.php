<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your Distro - Dashboard</title>

  <!-- Tailwind CSS & Vite -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Inter Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <!-- Alpine.js -->
  <script src="https://unpkg.com/alpinejs" defer></script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    ::-webkit-scrollbar-track {
      background: #1a1a1a;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
      background: #4a4a4a;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #6a6a6a;
    }
  </style>
</head>
<body x-data="{ sidebarOpen: false }" class="bg-zinc-950 text-gray-100 min-h-screen flex overflow-x-hidden">

  <!-- Wrapper -->
  <div class="flex min-h-screen w-full overflow-hidden relative">

    <!-- Overlay for mobile -->
    <div 
      x-show="sidebarOpen"
      @click="sidebarOpen = false"
      class="fixed inset-0 z-30 bg-black bg-opacity-50 md:hidden"
      x-transition:enter="transition-opacity ease-out duration-200"
      x-transition:leave="transition-opacity ease-in duration-150"
      x-cloak>
    </div>

    <!-- Sidebar -->
    <aside 
      class="fixed top-0 left-0 h-full w-64 bg-zinc-900 p-6 z-40 transform md:relative md:translate-x-0 transition-transform duration-300 ease-in-out"
      :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }"
      x-cloak>
      
      <!-- Close button on mobile -->
      <div class="flex justify-end md:hidden mb-4">
        <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white">
          <i class="fas fa-times text-xl"></i>
        </button>
      </div>

      @include('partials.user.sidebar')
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <!-- Header -->
      <header class="bg-zinc-900 p-4 flex items-center justify-between shadow-lg z-10">
        @php
    $route = Route::currentRouteName();

    $titles = [
        'user.dashboard' => 'Dashboard Overview',
        'profile.show' => 'Profile Settings',
        'user.settings' => 'User Settings',
        'release' => 'My Releases',
        'music.upload' => 'Upload Music',
        'user.payment' => 'Payment Settings',
    ];

    $pageTitle = $titles[$route] ?? 'Dashboard';
@endphp

<h1 class="text-2xl md:text-3xl font-bold text-white">{{ $pageTitle }}</h1>

        <div class="flex items-center space-x-4">
          <i class="fas fa-bell text-gray-400 text-xl hover:text-white cursor-pointer"></i>
          <i class="fas fa-envelope text-gray-400 text-xl hover:text-white cursor-pointer"></i>

          <a href="{{ route('music.upload') }}"
             class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-full shadow-md transition duration-300 ease-in-out transform hover:scale-105 flex items-center text-base">
            <i class="fas fa-plus mr-2"></i> {{ __("New Release") }}
          </a>

          <!-- Hamburger Menu -->
          <button 
            @click="sidebarOpen = !sidebarOpen"
            class="md:hidden text-gray-400 text-xl hover:text-white focus:outline-none"
            aria-label="Toggle sidebar">
            <i class="fas fa-bars"></i>
          </button>
        </div>
      </header>
@include('partials.user.sessions')
      <!-- Page Content -->
      <main class="flex-1 p-4 sm:p-6 overflow-x-auto">
        @yield('content')
      </main>
    </div>
  </div>
</body>
</html>
