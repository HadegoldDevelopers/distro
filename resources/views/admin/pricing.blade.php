@extends('layouts.admin')

@section('title', 'Subscription Plans')

@section('content')
<div class="p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Subscription Plans</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.pricing.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create New Plan</a>

    <table class="min-w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="py-2 px-4 border-b">Name</th>
                <th class="py-2 px-4 border-b">Role</th>
                <th class="py-2 px-4 border-b">Price</th>
                <th class="py-2 px-4 border-b">Billing Cycle</th>
                <th class="py-2 px-4 border-b">Currency</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($plans as $plan)
            <tr class="hover:bg-gray-50">
                <td class="py-2 px-4 border-b">{{ $plan->name }}</td>
                <td class="py-2 px-4 border-b capitalize">{{ $plan->role }}</td>
                <td class="py-2 px-4 border-b">{{ $plan->currency }} {{ number_format($plan->price, 2) }}</td>
                <td class="py-2 px-4 border-b capitalize">{{ $plan->billing_cycle }}</td>
                <td class="py-2 px-4 border-b uppercase">{{ $plan->currency }}</td>
                <td class="py-2 px-4 border-b">
                    <a href="{{ route('admin.pricing.edit', $plan->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                    <form action="{{ route('admin.pricing.destroy', $plan->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this plan?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center py-4 text-gray-500">No plans found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $plans->links() }}
    </div>
</div>
@endsection
