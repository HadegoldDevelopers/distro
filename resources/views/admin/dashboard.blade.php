@extends('layouts.admin')

@section('title', 'Music Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 p-8">
  <h1 class="text-4xl font-extrabold text-gray-900 mb-10">Welcome back, Admin 👋</h1>

  {{-- Top Metrics --}}
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
    {{-- Registered Artists --}}
    <div class="bg-white shadow-md rounded-xl text-center p-6 border-t-4 border-blue-500">
      <p class="text-sm text-gray-500 uppercase">Total Artists</p>
      <p class="text-4xl font-bold text-blue-600 mt-2">{{ $totalUsers ?? '12,345' }}</p>
    </div>

    {{-- New Signups --}}
    <div class="bg-white shadow-md rounded-xl text-center p-6 border-t-4 border-pink-500">
      <p class="text-sm text-gray-500 uppercase">New Signups</p>
      <p class="text-4xl font-bold text-pink-600 mt-2">{{ $newSignups ?? '1,234' }}</p>
    </div>

    {{-- Total Revenue --}}
    <div class="bg-white shadow-md rounded-xl text-center p-6 border-t-4 border-yellow-500">
      <p class="text-sm text-gray-500 uppercase">Total Revenue</p>
      <p class="text-4xl font-bold text-yellow-600 mt-2">${{ $totalRevenue ?? '52,510' }}</p>
    </div>
  </div>

  {{-- Chart Section: Monthly Album Uploads --}}
  <div class="bg-white shadow-md rounded-xl p-6 mb-12">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl font-semibold text-gray-700">Albums Uploaded Monthly</h2>
      <span class="text-sm text-gray-400">Last 30 days</span>
    </div>
    <div id="albumChart" class="w-full"></div>
  </div>

  {{-- Secondary Metrics --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    {{-- Total Releases --}}
    <div class="bg-white shadow-lg rounded-lg p-6 border-t-4 border-purple-500">
      <p class="text-sm text-gray-500 uppercase">Total Releases</p>
      <p class="text-3xl font-extrabold text-purple-700 mt-2">{{ $totalReleases ?? '45,678' }}</p>
    </div>

    {{-- Pending Approvals --}}
    <div class="bg-white shadow-lg rounded-lg p-6 border-t-4 border-yellow-500">
      <p class="text-sm text-gray-500 uppercase">Pending Approvals</p>
      <p class="text-3xl font-extrabold text-yellow-700 mt-2">{{ $pendingApprovals ?? '78' }}</p>
    </div>

    {{-- Support Tickets --}}
    <div class="bg-white shadow-lg rounded-lg p-6 border-t-4 border-red-500">
      <p class="text-sm text-gray-500 uppercase">Open Support Tickets</p>
      <p class="text-3xl font-extrabold text-red-600 mt-2">{{ $openTickets ?? '15' }}</p>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const albumOptions = {
    chart: {
      type: 'area',
      height: 300,
      toolbar: { show: false }
    },
    series: [{
      name: 'Albums',
      data: @json(array_values($albumUploads))
    }],
    xaxis: {
      categories: @json(array_keys($albumUploads)),
      labels: { style: { colors: '#9CA3AF' } }
    },
    colors: ['#8b5cf6'],
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.5,
        opacityTo: 0.1,
        stops: [0, 90, 100]
      }
    },
    stroke: {
      curve: 'smooth',
      width: 3
    }
  };

  new ApexCharts(document.querySelector("#albumChart"), albumOptions).render();
</script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endpush
