@extends('layouts.admin')

@section('title', 'Submitted Releases')

@section('content')
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Submitted Releases</h1>

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
      @forelse($datas as $data)
      <tr class="hover:bg-gray-50">
        <td class="py-2 px-4 border-b">{{ $data->title }}</td>
        <td class="py-2 px-4 border-b">{{ $data->artist }}</td>
        <td class="py-2 px-4 border-b">{{ $data->genre }}</td>
        <td class="py-2 px-4 border-b">{{ $data->release_date }}</td>
        <td class="py-2 px-4 border-b">
        <audio controls class="w-32">
        <source src="{{ asset('storage/' . $data->audio_path) }}" type="audio/mpeg">
        Your browser does not support the audio element.
        </audio>
        </td>
        <td class="py-2 px-4 border-b">
        <img src="{{ asset('storage/' . $data->cover_path) }}" alt="Cover" class="h-12 w-12 rounded object-cover">
        </td>
        <td class="py-2 px-4 border-b capitalize">{{ $data->status }}</td>
        
      <td class="py-2 px-4 border-b">
  <a href="{{ route('admin.releases.metadata', $data->id) }}" class="text-blue-600 hover:underline mr-2">
    Edit Metadata
  </a>

  @if($data->status !== 'approved')
    <form action="{{ route('admin.approve.music', $data->id) }}" method="POST" class="inline">
      @csrf
      <button type="submit" class="text-green-600 hover:underline ml-2">Approve</button>
    </form>
  @endif

  @if($data->status !== 'rejected')
    <form action="{{ route('admin.reject.music', $data->id) }}" method="POST" class="inline ml-2">
      @csrf
      <button type="submit" class="text-red-600 hover:underline">Reject</button>
    </form>
  @endif
</td>
</tr>
    @empty
      <tr>
      <td colspan="8" class="text-center py-4 text-gray-500">No Release submitted yet.</td>
      </tr>
    @endforelse
      </tbody>
    </table>
    </div>
  </div>
@endsection