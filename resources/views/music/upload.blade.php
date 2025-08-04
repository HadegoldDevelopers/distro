@extends('layouts.user')

@section('title', 'Upload Music')

@section('content')
  <div class="max-w-4xl mx-auto bg-zinc-900 text-white p-8 rounded-lg shadow-xl mt-12">
    <h2 class="text-2xl font-bold text-orange-500 mb-6 flex items-center">
    <i class="fas fa-upload mr-2"></i> Upload New Music
    </h2>

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-600/20 text-green-300 rounded">
    {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('music.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
      <label class="block mb-1 text-sm font-medium">Song Title</label>
      <input type="text" name="title" class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2" required>
      </div>

      <div>
      <label class="block mb-1 text-sm font-medium">Primary Artist</label>
      <input type="text" name="artist" value="{{ Auth::user()->name }}"
        class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2" required>
      </div>

      <div>
      <label class="block mb-1 text-sm font-medium">Featured Artist(s)</label>
      <input type="text" name="featured_artists" class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2"
        placeholder="Separate multiple names with commas">
      </div>

      <div>
      <label class="block mb-1 text-sm font-medium">Album Name</label>
      <input type="text" name="album" class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2">
      </div>

      <div>
      <label class="block mb-1 text-sm font-medium">Genre</label>
      <input type="text" name="genre" class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2">
      </div>

      <div>
      <label class="block mb-1 text-sm font-medium">Subgenre (optional)</label>
      <input type="text" name="subgenre" class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2">
      </div>

      <div>
      <label class="block mb-1 text-sm font-medium">Release Date</label>
      <input type="date" name="release_date" class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2"
        required>
      </div>

      <div>
      <label class="block mb-1 text-sm font-medium">Track Number</label>
      <input type="number" name="track_number" min="1"
        class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2">
      </div>

      <div>
      <label class="block mb-1 text-sm font-medium">Music Type</label>
      <select name="type" class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2">
        <option value="Single">Single</option>
        <option value="EP">EP</option>
        <option value="Album">Album</option>
      </select>
      </div>

      <div>
      <label class="block mb-1 text-sm font-medium">Language</label>
      <input type="text" name="language" class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2"
        placeholder="e.g. English, Yoruba">
      </div>

      <div>
      <label class="block mb-1 text-sm font-medium">Explicit Lyrics?</label>
      <select name="explicit" class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2">
        <option value="no">No</option>
        <option value="yes">Yes</option>
      </select>
      </div>

      <div>
      <label class="block mb-1 text-sm font-medium">Label / Publisher</label>
      <input type="text" name="label" class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2">
      </div>

      <div>
      <label class="block mb-1 text-sm font-medium">Songwriter / Composer</label>
      <input type="text" name="songwriter" class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2"
        placeholder="e.g. John Doe, Jane Doe">
      </div>

      <div>
      <label class="block mb-1 text-sm font-medium">ISRC (optional)</label>
      <input type="text" name="isrc" class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2"
        placeholder="Leave blank to auto-generate">
      </div>

      <div>
      <label class="block mb-1 text-sm font-medium">UPC (optional)</label>
      <input type="text" name="upc" class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2">
      </div>

      <div class="md:col-span-2">
      <label class="block mb-1 text-sm font-medium">Copyright Holder</label>
      <input type="text" name="copyright" class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2">
      </div>
    </div>

    <div>
      <label class="block mb-1 text-sm font-medium">Cover Image</label>
      <input type="file" name="cover" accept="image/*"
      class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2 file:bg-orange-600 file:text-white file:border-0 file:rounded file:py-2 file:px-4 hover:file:bg-orange-700">
    </div>

    <div>
      <label class="block mb-1 text-sm font-medium">Audio File (MP3/WAV)</label>
      <input type="file" name="audio" accept=".mp3,.wav"
      class="w-full bg-zinc-800 border border-zinc-700 rounded px-4 py-2 file:bg-indigo-600 file:text-white file:border-0 file:rounded file:py-2 file:px-4 hover:file:bg-indigo-700"
      required>
    </div>

    <div class="pt-4">
      <button type="submit"
      class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out">
      <i class="fas fa-cloud-upload-alt mr-2"></i> Submit Upload
      </button>
    </div>
    </form>
  </div>
@endsection