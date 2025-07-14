@extends('layouts.user')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-zinc-900 rounded-lg shadow space-y-6 mt-8">

    <h2 class="text-2xl font-bold text-white">User Settings</h2>

    <form action="{{ route('user.settings.update') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
        @csrf

        <!-- Artist Name -->
        <div>
            <label class="block text-sm text-gray-300 mb-1">Artist Name</label>
            <input type="text" name="artist_name"
                value="{{ old('artist_name', auth()->user()->artist_name) }}"
                class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded text-white focus:outline-none focus:ring focus:border-orange-500">
        </div>

        <!-- Audiomack -->
        <div>
            <label class="block text-sm text-gray-300 mb-1">Audiomack Username/URL</label>
            <input type="text" name="user_audiomack"
                value="{{ old('user_audiomack', auth()->user()->user_audiomack) }}"
                class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded text-white focus:outline-none focus:ring focus:border-orange-500">
        </div>

        <!-- Spotify -->
        <div>
            <label class="block text-sm text-gray-300 mb-1">Spotify Artist ID/URL</label>
            <input type="text" name="user_spotify"
                value="{{ old('user_spotify', auth()->user()->user_spotify) }}"
                class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded text-white focus:outline-none focus:ring focus:border-orange-500">
        </div>

        <!-- Apple Music -->
<div>
  <label class="block text-sm text-gray-300 mb-1">Apple Music Artist URL</label>
  <input type="text" name="user_applemusic_id"
      value="{{ old('user_applemusic_id', auth()->user()->user_applemusic_id) }}"
      class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded text-white focus:outline-none focus:ring focus:border-orange-500">
</div>
        <!-- Profile Image -->
        <div>
            <label class="block text-sm text-gray-300 mb-1">Profile Image URL</label>
            <input type="file" name="user_profileimage" accept="image/*"
                class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded text-white focus:outline-none focus:ring focus:border-orange-500">
            <p class="text-xs text-gray-500 mt-1">Upload a new profile image (optional). Supported formats: JPG, PNG.</p>
        </div>

        <!-- Email Notifications -->
<div class="flex items-center space-x-3">
  <input type="hidden" name="email_notifications" value="0">
  <input type="checkbox" name="email_notifications" id="email_notifications" value="1"
      {{ old('email_notifications', auth()->user()->email_notifications) ? 'checked' : '' }}>
  <label for="email_notifications" class="text-gray-300">Enable Email Notifications</label>
</div>

<!-- Dark Mode -->
<div class="flex items-center space-x-3">
  <input type="hidden" name="dark_mode" value="0">
  <input type="checkbox" name="dark_mode" id="dark_mode" value="1"
      {{ old('dark_mode', auth()->user()->dark_mode) ? 'checked' : '' }}>
  <label for="dark_mode" class="text-gray-300">Enable Dark Mode</label>
</div>


        <!-- Save Button -->
        <div>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded transition duration-200">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection
