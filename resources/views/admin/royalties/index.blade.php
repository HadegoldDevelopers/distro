@extends('layouts.admin')

@section('title', 'Royalties Reports Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Royalties Dashboard</h1>

    {{-- Filter --}}
    <form method="GET" class="mb-6 flex flex-wrap gap-4 items-center">
        <label for="range" class="font-semibold text-sm text-gray-700">Filter by:</label>
        <select name="range" id="range" class="p-2 border rounded">
            <option value="all" {{ request('range') == 'all' ? 'selected' : '' }}>All Time</option>
            <option value="today" {{ request('range') == 'today' ? 'selected' : '' }}>Today</option>
            <option value="month" {{ request('range') == 'month' ? 'selected' : '' }}>This Month</option>
        </select>
        <button class="bg-indigo-600 text-white px-3 py-2 rounded hover:bg-indigo-700">Apply</button>
    </form>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow rounded p-4">
            <p class="text-sm text-gray-600">Total Earnings ($)</p>
            <p class="text-2xl font-bold text-green-600">
                ${{ number_format($stats['total_earnings'] ?? 0, 2) }}
            </p>
        </div>

        <div class="bg-white shadow rounded p-4">
            <p class="text-sm text-gray-600">Total Streams</p>
            <p class="text-2xl font-bold text-blue-600">
                {{ number_format($stats['total_streams'] ?? 0) }}
            </p>
        </div>

        <div class="bg-white shadow rounded p-4">
            <p class="text-sm text-gray-600">Payout to Artists ($)</p>
            <p class="text-2xl font-bold text-purple-600">
                ${{ number_format($stats['artist_payout'] ?? 0, 2) }}
            </p>
        </div>

        <div class="bg-white shadow rounded p-4">
            <p class="text-sm text-gray-600">Payout to Labels ($)</p>
            <p class="text-2xl font-bold text-yellow-600">
                ${{ number_format($stats['label_payout'] ?? 0, 2) }}
            </p>
        </div>

        <div class="bg-white shadow rounded p-4">
            <p class="text-sm text-gray-600">Unique Tracks</p>
            <p class="text-2xl font-bold text-indigo-600">
                {{ $stats['track_count'] ?? 0 }}
            </p>
        </div>

        <div class="bg-white shadow rounded p-4">
            <p class="text-sm text-gray-600">Countries Reached</p>
            <p class="text-2xl font-bold text-rose-600">
                {{ $stats['countries'] ?? 0 }}
            </p>
        </div>
    </div>

    {{-- Reports Section --}}
    <div class="bg-white shadow rounded-lg p-6 space-y-4">
        <div class="flex flex-wrap gap-3">
    <a href="{{ route('admin.royalties.reports.royalties') }}"
       class="px-4 py-1.5 bg-indigo-600 text-white text-sm font-medium rounded-md shadow hover:bg-indigo-700 transition">
        Royalties Report
    </a>

    <a href="{{ route('admin.royalties.reports.streams') }}"
       class="px-4 py-1.5 bg-indigo-600 text-white text-sm font-medium rounded-md shadow hover:bg-indigo-700 transition">
        Streams Report
    </a>

    <a href="{{ route('admin.royalties.reports.earnings') }}"
       class="px-4 py-1.5 bg-indigo-600 text-white text-sm font-medium rounded-md shadow hover:bg-indigo-700 transition">
        Earnings Report
    </a>
</div>


        {{-- Upload CSV --}}
        <div>
            <h2 class="text-lg font-semibold mb-2">Upload Earnings CSV</h2>
            <form action="{{ route('admin.royalties.reports.upload') }}" method="POST" enctype="multipart/form-data"
                  class="max-w-md mx-auto p-4 bg-white rounded shadow">
                @csrf

                <label for="distributor" class="block mb-2 font-semibold">Choose Distributor:</label>
                <select name="distributor" id="distributor" required class="w-full p-2 border rounded mb-4">
                    <option value="">-- Select Distributor --</option>
                    <option value="default">Auto Detect</option>
                    <option value="distrokid">DistroKid</option>
                    <option value="soundrop">Soundrop</option>
                    <option value="horus">Horus Music</option>
                    <option value="vydia">Vydia</option>
                    <option value="cdbaby">CD Baby</option>
                </select>

                <label for="earnings_csv" class="block mb-2 font-semibold">Upload CSV Report:</label>
                <input type="file" name="earnings_csv" id="earnings_csv" required class="w-full mb-4">

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Upload
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
