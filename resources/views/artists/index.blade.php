@extends('layouts.user')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-300">Artists</h1>
        <a href="{{ route('artists.create') }}" 
           class="inline-flex items-center space-x-2 bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-semibold transition">
            <i class="fas fa-plus"></i>
            <span>Add New Artist</span>
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-700 text-green-100 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-zinc-800 rounded-lg shadow-lg">
        <table class="min-w-full divide-y divide-zinc-700">
            <thead class="bg-zinc-900 text-gray-400">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium uppercase">Genre</th>
                    <th class="px-6 py-3 text-left text-sm font-medium uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-medium uppercase">Spotify ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-700 text-gray-300">
                @forelse($artists as $artist)
                <tr class="hover:bg-zinc-700 transition">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $artist->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $artist->genre ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $artist->email ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $artist->spotify_id ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('artists.edit', $artist) }}" 
                           class="text-orange-500 hover:text-orange-600 font-semibold">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-500">No artists found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $artists->links() }}
    </div>
</div>
@endsection
