@extends('layouts.user')

@section('content')
<div class="max-w-4xl mx-auto p-6 text-gray-100">
    <h2 class="text-3xl font-bold mb-6">Profile Settings</h2>

    {{-- Update Profile Info --}}
    <div class="bg-zinc-800 rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-xl font-semibold mb-4">Update Profile</h3>
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                       class="w-full px-4 py-2 rounded-lg bg-zinc-700 text-white border border-zinc-600 focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                       class="w-full px-4 py-2 rounded-lg bg-zinc-700 text-white border border-zinc-600 focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <button type="submit"
                    class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                Save Changes
            </button>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="bg-zinc-800 rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-xl font-semibold mb-4">Change Password</h3>
        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Current Password</label>
                <input type="password" name="current_password"
                       class="w-full px-4 py-2 rounded-lg bg-zinc-700 text-white border border-zinc-600 focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">New Password</label>
                <input type="password" name="password"
                       class="w-full px-4 py-2 rounded-lg bg-zinc-700 text-white border border-zinc-600 focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full px-4 py-2 rounded-lg bg-zinc-700 text-white border border-zinc-600 focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                Update Password
            </button>
        </form>
    </div>

    {{-- Delete Account --}}
    <div class="bg-red-800 rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">Delete Account</h3>
        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account?');">
            @csrf
            @method('DELETE')

            <p class="mb-4 text-red-200">This action cannot be undone. All your data will be lost.</p>

            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                Delete My Account
            </button>
        </form>
    </div>
</div>
@endsection
