@extends('layouts.user')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
  <h2 class="text-2xl font-bold text-white mb-6">My Releases</h2>

  @if($releases->count())
    <div class="space-y-4">
      @foreach($releases as $release)
        <div class="bg-zinc-800 rounded-lg p-4 flex justify-between items-center shadow">
          <div class="flex items-center space-x-4">
            @if($release->cover_path)
              <img src="{{ asset('storage/' . $release->cover_path) }}" class="w-16 h-16 rounded object-cover" />
            @else
              <div class="w-16 h-16 bg-gray-600 rounded"></div>
            @endif
            <div>
              <h3 class="text-white font-semibold text-lg">{{ $release->title }}</h3>
              <p class="text-sm text-gray-400">
                Artist: {{ $release->artist }} <br>
                Released: {{ \Carbon\Carbon::parse($release->release_date)->format('M d, Y') }}
              </p>
            </div>
          </div>
          <a href="#" class="text-blue-400 hover:underline">View</a>
        </div>
      @endforeach
    </div>

    <div class="mt-6">
      {{ $releases->links() }}
    </div>
  @else
    <p class="text-gray-400">No releases found.</p>
  @endif
</div>
@endsection
