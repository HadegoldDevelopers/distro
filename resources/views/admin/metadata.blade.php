@extends('layouts.admin')

@section('title', 'Edit Metadata')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h1 class="text-2xl font-semibold mb-6">Edit Metadata: {{ $music->title }}</h1>

    <form action="{{ route('admin.releases.metadata.update', $music->id) }}" method="POST" class="space-y-6 bg-white p-6 rounded shadow">
        @csrf

        <div>
            <label class="block font-medium text-sm text-gray-700">Title</label>
            <input type="text" name="title" value="{{ old('title', $music->title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">Artist</label>
            <input type="text" name="artist" value="{{ old('artist', $music->artist) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">Genre</label>
            <input type="text" name="genre" value="{{ old('genre', $music->genre) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">Release Date</label>
            <input type="date" name="release_date" value="{{ old('release_date', $music->release_date) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">ISRC</label>
            <input type="text" name="isrc" value="{{ old('isrc', $music->isrc) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">UPC</label>
            <input type="text" name="upc" value="{{ old('upc', $music->upc) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">Credits</label>
            <textarea name="credits" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('credits', $music->credits) }}</textarea>
        </div>

        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Changes</button>
            <a href="{{ route('admin.releases.all') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection
