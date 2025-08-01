@extends('layouts.app')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Panel (Image) -->
    <div class="w-1/2 hidden md:flex flex-col justify-end items-center bg-gradient-to-t from-purple-700 to-blue-800 relative">
        <img src="{{ asset('images/dave-east.jpg') }}" alt="Artist" class="absolute inset-0 h-full w-full object-cover opacity-90">
        <div class="relative z-10 text-white p-8 text-center">
            <h3 class="text-lg font-semibold">Dave East</h3>
            <p class="text-sm mb-4">Distributed by Too Lost</p>
            <div class="flex justify-center space-x-4">
                <img src="{{ asset('images/spotify-icon.svg') }}" alt="Spotify" class="h-6 w-6">
                <img src="{{ asset('images/apple-icon.svg') }}" alt="Apple Music" class="h-6 w-6">
            </div>
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
    </div>

    <!-- Right Panel (Form) -->
    <div class="w-full md:w-1/2 flex items-center justify-center bg-white px-6 py-12">
        <div class="max-w-md w-full">
            <h2 class="text-2xl font-bold mb-6">Create your MusicVerse account</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                    placeholder="Your name"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                @error('name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <!-- Email -->
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    placeholder="Your email"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <!-- Password -->
                <input id="password" name="password" type="password" required
                    placeholder="Password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <!-- Confirm Password -->
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    placeholder="Confirm password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                @error('password_confirmation')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <!-- Submit -->
                <button type="submit"
                    class="w-full py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                    Register
                </button>
            </form>

            <!-- Link to Login -->
            <p class="mt-6 text-center text-sm text-gray-600">
                Already registered?
                <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:underline">Sign in</a>
            </p>
        </div>
    </div>
</div>
@endsection
