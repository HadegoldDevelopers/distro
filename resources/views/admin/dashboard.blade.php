@extends('layouts.admin') {{-- Optional layout file for admin --}}

@section('title', 'Admin Dashboard')

@section('content')
  <div class="min-h-screen flex bg-gray-100">
    <!-- Main Content -->
    <main class="flex-1 p-8">
    <div class="bg-white rounded-lg shadow px-6 py-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, Admin 🎉</h1>
      <p class="text-gray-600 mb-6">Here's an overview of your admin dashboard.</p>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Users Card -->
      <div class="bg-blue-50 p-5 rounded-lg border-l-4 border-blue-500 shadow-sm">
        <h2 class="text-lg font-bold text-blue-800">Manage Users</h2>
        <p class="text-blue-700 mt-2">View and manage registered users.</p>
        <a href="{{ route('admin.users') }}"
        class="mt-4 inline-block text-sm text-blue-600 hover:underline font-medium">Go to Users</a>
      </div>

      <!-- Songs Card -->
      <div class="bg-green-50 p-5 rounded-lg border-l-4 border-green-500 shadow-sm">
        <h2 class="text-lg font-bold text-green-800">Submitted Songs</h2>
        <p class="text-green-700 mt-2">Review and approve user-submitted songs.</p>
        <a href="{{ route('admin.uploads') }}"
        class="mt-4 inline-block text-sm text-green-600 hover:underline font-medium">Go to Songs</a>
      </div>

      <!-- System Settings or Stats (Optional) -->
      <div class="bg-yellow-50 p-5 rounded-lg border-l-4 border-yellow-500 shadow-sm">
        <h2 class="text-lg font-bold text-yellow-800">System Info</h2>
        <p class="text-yellow-700 mt-2">Total Users, Uploads, and Admin Logs.</p>
        <span class="inline-block mt-4 text-yellow-600 font-medium text-sm">Coming soon...</span>
      </div>
      </div>
    </div>
    </main>
  </div>
@endsection