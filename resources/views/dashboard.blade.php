@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')

    @if(auth()->user()->role === 'label')
        <!-- Label Dashboard -->

        <!-- Overview Cards -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-zinc-800 rounded-lg p-6 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-300">Total Uploads</h2>
                    <i class="fas fa-cloud-upload-alt text-orange-500 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-white">{{ $submittedSongs }}</p>
                <p class="text-sm text-gray-400 mt-2">
                    @if ($percentChange > 0)
                        <span class="text-green-400">+{{ $percentChange }}%</span> from last month
                    @elseif($percentChange < 0)
                        <span class="text-red-400">{{ $percentChange }}%</span> from last month
                    @else
                        No change from last month
                    @endif
                </p>
            </div>

            <div class="bg-zinc-800 rounded-lg p-6 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-300">Total Streams</h2>
                    <i class="fas fa-play-circle text-blue-500 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-white">
                    {{ number_format($totalStreams) }}
                </p>
                <p class="text-sm text-gray-400 mt-2">
                    Based on your uploaded music
                </p>
            </div>

            <div class="bg-zinc-800 rounded-lg p-6 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-300">Earnings (Est.)</h2>
                    <i class="fas fa-dollar-sign text-green-500 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-white">{{ $totalEarnings }}</p>
                <p class="text-sm text-gray-400 mt-2">Last 30 days</p>
            </div>
            <div class="bg-zinc-800 rounded-lg p-6 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-300">Active Artists</h2>
                    <i class="fas fa-users-line text-purple-500 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-white">{{ $totalArtists }}</p>
                <p class="text-sm text-gray-400 mt-2">Currently distributing</p>
            </div>
        </section>

        <!-- Streams Over Time Chart -->
        <section class="bg-zinc-800 rounded-lg p-6 shadow-xl mb-8">
            <h2 class="text-xl font-semibold text-gray-300 mb-4">Streams Over Time</h2>
            @if($streamChartData->isEmpty() || $streamChartData->sum('total_streams') == 0)
                <div class="h-64 bg-zinc-700 rounded-md flex items-center justify-center text-gray-500 text-lg">
                    No data to display
                </div>
            @else
                <canvas id="streamsChart" class="w-full h-64 bg-zinc-700 rounded-md p-4"></canvas>
                <script>
                    const ctx = document.getElementById('streamsChart').getContext('2d');
                    const chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($streamChartData->pluck('month')) !!},
                            datasets: [{
                                label: 'Streams',
                                data: {!! json_encode($streamChartData->pluck('total_streams')) !!},
                                borderColor: '#3B82F6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.4,
                                fill: true,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { color: '#ccc' }
                                },
                                x: {
                                    ticks: { color: '#ccc' }
                                }
                            },
                            plugins: {
                                legend: { labels: { color: '#ccc' } }
                            }
                        }
                    });
                </script>
            @endif
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Uploads Table -->
            <section class="bg-zinc-800 rounded-lg p-6 shadow-xl">
                <h2 class="text-xl font-semibold text-gray-300 mb-4">Recent Uploads</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-700">
                        <thead class="bg-zinc-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider rounded-tl-lg">Track</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Uploaded By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider rounded-tr-lg">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-700">
                            @forelse ($musics as $music)
                                <tr class="hover:bg-zinc-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                        @if($music->cover_path)
                                            <img src="{{ asset('storage/' . $music->cover_path) }}" alt="Album Art" class="w-10 h-10 rounded-md mr-3 object-cover">
                                        @else
                                            <img src="https://placehold.co/40x40/333/fff?text=M" alt="Album Art" class="w-10 h-10 rounded-md mr-3 object-cover">
                                        @endif
                                        <span class="text-white font-medium">{{ $music->title }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $music->user->name ?? 'You' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'approved' => 'bg-green-500/20 text-green-400',
                                                'pending' => 'bg-yellow-500/20 text-yellow-400',
                                                'rejected' => 'bg-red-500/20 text-red-400',
                                            ];
                                            $status = strtolower($music->status);
                                            $classes = $statusColors[$status] ?? 'bg-gray-500/20 text-gray-400';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $classes }}">
                                            {{ ucfirst($music->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-400">{{ $music->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-400">No uploads found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Quick Actions -->
            <section class="bg-zinc-800 rounded-lg p-6 shadow-xl">
                <h2 class="text-xl font-semibold text-gray-300 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('music.upload') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-4 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center space-x-3">
                        <i class="fas fa-plus-circle text-2xl"></i>
                        <span>{{ __('New Release') }}</span>
                    </a>
                    <button class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-4 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center space-x-3">
                        <i class="fas fa-file-export text-2xl"></i>
                        <span>Export Data</span>
                    </button>
                    <button class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-4 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center space-x-3">
                        <i class="fas fa-headset text-2xl"></i>
                        <span>Support</span>
                    </button>
                    <a href="{{ route('artists.index') }}" class="bg-rose-600 hover:bg-rose-700 text-white font-semibold py-4 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center space-x-3">
                        <i class="fas fa-users-gear text-2xl"></i>
                        <span>{{ __('Manage Artists') }}</span>
                    </a>
                </div>
            </section>
        </div>

    @elseif(auth()->user()->role === 'artist')
    <!-- Artist Dashboard -->

    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-zinc-800 rounded-lg p-6 shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-300">Your Uploads</h2>
                <i class="fas fa-cloud-upload-alt text-orange-500 text-2xl"></i>
            </div>
            <p class="text-4xl font-bold text-white">{{ $submittedSongs }}</p>
        </div>

        <div class="bg-zinc-800 rounded-lg p-6 shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-300">Your Streams</h2>
                <i class="fas fa-play-circle text-blue-500 text-2xl"></i>
            </div>
            <p class="text-4xl font-bold text-white">{{ number_format($totalStreams) }}</p>
        </div>

        <div class="bg-zinc-800 rounded-lg p-6 shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-300">Earnings (Est.)</h2>
                <i class="fas fa-dollar-sign text-green-500 text-2xl"></i>
            </div>
            <p class="text-4xl font-bold text-white">{{ $totalEarnings }}</p>
            <p class="text-sm text-gray-400 mt-2">Last 30 days</p>
        </div>
    </section>

    <!-- Recent Uploads Table -->
    <section class="bg-zinc-800 rounded-lg p-6 shadow-xl">
        <h2 class="text-xl font-semibold text-gray-300 mb-4">Recent Uploads</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-700">
                <thead class="bg-zinc-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider rounded-tl-lg">Track</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider rounded-tr-lg">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-700">
                    @forelse ($musics as $music)
                        <tr class="hover:bg-zinc-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                @if($music->cover_path)
                                    <img src="{{ asset('storage/' . $music->cover_path) }}" alt="Album Art" class="w-10 h-10 rounded-md mr-3 object-cover">
                                @else
                                    <img src="https://placehold.co/40x40/333/fff?text=M" alt="Album Art" class="w-10 h-10 rounded-md mr-3 object-cover">
                                @endif
                                <span class="text-white font-medium">{{ $music->title }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'approved' => 'bg-green-500/20 text-green-400',
                                        'pending' => 'bg-yellow-500/20 text-yellow-400',
                                        'rejected' => 'bg-red-500/20 text-red-400',
                                    ];
                                    $status = strtolower($music->status);
                                    $classes = $statusColors[$status] ?? 'bg-gray-500/20 text-gray-400';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $classes }}">
                                    {{ ucfirst($music->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-400">{{ $music->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-400">No uploads found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-6 flex flex-wrap gap-4 items-center">
        <a href="{{ route('music.upload') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center space-x-3 w-max">
            <i class="fas fa-plus-circle text-2xl"></i>
            <span>{{ __('Upload New Track') }}</span>
        </a>

        <a href="#" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center space-x-3 w-max">
            <i class="fas fa-headset text-2xl"></i>
            <span>Contact Support</span>
        </a>
    </div>

    @else
        <p class="text-white">Role not recognized.</p>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
