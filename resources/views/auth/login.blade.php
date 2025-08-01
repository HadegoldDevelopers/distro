@extends('layouts.app')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Panel with Image -->
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
            <h2 class="text-2xl font-bold mb-6">Sign in to MusicVerse</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <input type="email" name="email" placeholder="Type in your email" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">

                <div class="relative">
                    <input type="password" name="password" placeholder="Type in your password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <!-- Optional: password visibility toggle here -->
                </div>

                <div class="text-sm text-gray-600">
                    <a href="{{ route('password.request') }}" class="hover:underline font-semibold">Recover your account</a>
                </div>

                <button type="submit"
                    class="w-full py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                    Sign in
                </button>
            </form>

            <!-- Social Logins -->
            <div class="mt-4 space-y-3">
                <button class="w-full py-3 border border-gray-300 rounded-lg flex items-center justify-center gap-2">
                    <img src="{{ asset('images/google-icon.svg') }}" class="h-5 w-5" alt="Google"> Sign in with Google
                </button>

                <button class="w-full py-3 border border-gray-300 rounded-lg flex items-center justify-center gap-2">
                    <img src="{{ asset('images/apple-icon.svg') }}" class="h-5 w-5" alt="Apple"> Sign in with Apple
                </button>
            </div>

            <p class="mt-6 text-sm text-center text-gray-600">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-purple-600 font-semibold hover:underline">Register now</a>
            </p>
        </div>
    </div>
</div>
@endsection
