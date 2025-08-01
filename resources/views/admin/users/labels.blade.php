@extends('layouts.admin') 

@section('content')
<div class="p-6 space-y-8">

    <h2 class="text-2xl font-semibold text-gray-800">User Overview</h2>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Today Signups -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-bold text-gray-700">Today’s Signups</h3>
            <p class="text-4xl mt-2 text-blue-600">{{ $todaySignups->count() }}</p>
        </div>

        <!-- Last 7 Days Signups -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-bold text-gray-700">Signups (Last 7 Days)</h3>
            <p class="text-4xl mt-2 text-green-600">{{ $last7DaysSignups->count() }}</p>
        </div>
    </div>

    <!-- Active Users Table -->
    <div class="bg-white shadow rounded-lg">
        <div class="p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-700">Active Users</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Signup Date</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeUsers as $user)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                    Active
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-center text-gray-500">No active users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
