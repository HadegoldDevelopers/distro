<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Panel')</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-800">
  <div class="min-h-screen flex">
    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-white shadow-md h-screen px-6 py-8 hidden md:block">
      <h2 class="text-2xl font-bold text-indigo-700 mb-8">🎧 Admin Panel</h2>

      <nav class="space-y-4">
        <a href="{{ route('admin.dashboard') }}"
          class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
          📊 Dashboard
        </a>
        <a href="{{ route('admin.users') }}"
          class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 {{ request()->routeIs('admin.users') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
          👥 Manage Users
        </a>
        <a href="{{ route('admin.uploads') }}"
          class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 {{ request()->routeIs('admin.uploads') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
          🎶 Submitted Songs
        </a>
        <form action="{{ route('admin.logout') }}" method="POST">
          @csrf
          <button type="submit"
            class="w-full text-left px-4 py-2 rounded-lg text-red-600 hover:bg-red-100 hover:text-red-700">
            🚪 Logout
          </button>
        </form>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
      @yield('content')
    </main>
  </div>
</body>

</html>