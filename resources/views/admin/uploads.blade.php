@extends('layouts.admin')

@section('title', 'Submitted Songs')

@section('content')
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Submitted Songs</h1>

    @if(session('status'))
    <div class="mb-4 text-green-700 bg-green-100 p-4 rounded">
      {{ session('status') }}
    </div>
    @endif

    <table class="min-w-full bg-white border border-gray-200">
      <thead>
      <tr class="bg-gray-100 text-left">
        <th class="py-2 px-4 border-b">Title</th>
        <th class="py-2 px-4 border-b">Artist</th>
        <th class="py-2 px-4 border-b">Genre</th>
        <th class="py-2 px-4 border-b">Release Date</th>
        <th class="py-2 px-4 border-b">Audio</th>
        <th class="py-2 px-4 border-b">Cover</th>
        <th class="py-2 px-4 border-b">Status</th>
        <th class="py-2 px-4 border-b">Actions</th>
      </tr>
      </thead>
      <tbody>
      @forelse($songs as $song)
      <tr class="hover:bg-gray-50">
        <td class="py-2 px-4 border-b">{{ $song->title }}</td>
        <td class="py-2 px-4 border-b">{{ $song->artist }}</td>
        <td class="py-2 px-4 border-b">{{ $song->genre }}</td>
        <td class="py-2 px-4 border-b">{{ $song->release_date }}</td>
        <td class="py-2 px-4 border-b">
        <audio controls class="w-32">
        <source src="{{ asset('storage/' . $song->audio_path) }}" type="audio/mpeg">
        Your browser does not support the audio element.
        </audio>
        </td>
        <td class="py-2 px-4 border-b">
        <img src="{{ asset('storage/' . $song->cover_path) }}" alt="Cover" class="h-12 w-12 rounded object-cover">
        </td>
        <td class="py-2 px-4 border-b capitalize">{{ $song->status }}</td>
        <td class="py-2 px-4 border-b">
        @if($song->status !== 'approved')
      <form action="{{ route('admin.songs.approve', $song->id) }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="text-green-600 hover:underline">Approve</button>
      </form>
      @endif
        @if($song->status !== 'rejected')
      <form action="{{ route('admin.songs.reject', $song->id) }}" method="POST" class="inline ml-2">
        @csrf
        <button type="submit" class="text-red-600 hover:underline">Reject</button>
      </form>
      @endif
        </td>
      </tr>
    @empty
      <tr>
      <td colspan="8" class="text-center py-4 text-gray-500">No songs submitted yet.</td>
      </tr>
    @endforelse
      </tbody>
    </table>
    </div>
  </div>
@endsection