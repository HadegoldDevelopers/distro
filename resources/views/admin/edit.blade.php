@extends('layouts.admin')

@section('title', 'Edit Subscription Plan')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Edit Plan</h1>

    <form action="{{ route('admin.pricing.update',  ['plan' => $plan->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block font-medium mb-1">Plan Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $plan->name) }}" class="w-full border p-2 rounded" required>
            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="role" class="block font-medium mb-1">Role</label>
            <select name="role" id="role" class="w-full border p-2 rounded" required>
                <option value="">-- Select Role --</option>
                <option value="artist" {{ old('role', $plan->role) == 'artist' ? 'selected' : '' }}>Artist</option>
                <option value="label" {{ old('role', $plan->role) == 'label' ? 'selected' : '' }}>Label</option>
                <option value="listener" {{ old('role', $plan->role) == 'listener' ? 'selected' : '' }}>Listener</option>
                <option value="admin" {{ old('role', $plan->role) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="block font-medium mb-1">Price</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $plan->price) }}" class="w-full border p-2 rounded" required>
            @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="billing_cycle" class="block font-medium mb-1">Billing Cycle</label>
            <select name="billing_cycle" id="billing_cycle" class="w-full border p-2 rounded" required>
                <option value="">-- Select Billing Cycle --</option>
                <option value="monthly" {{ old('billing_cycle', $plan->billing_cycle) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="yearly" {{ old('billing_cycle', $plan->billing_cycle) == 'yearly' ? 'selected' : '' }}>Yearly</option>
            </select>
            @error('billing_cycle') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="currency" class="block font-medium mb-1">Currency</label>
            <select name="currency" id="currency" class="w-full border p-2 rounded" required>
                <option value="">-- Select Currency --</option>
                <option value="USD" {{ old('currency', $plan->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                <option value="EUR" {{ old('currency', $plan->currency) == 'EUR' ? 'selected' : '' }}>EUR</option>
                <option value="GBP" {{ old('currency', $plan->currency) == 'GBP' ? 'selected' : '' }}>GBP</option>
                <!-- Add more currencies as needed -->
            </select>
            @error('currency') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block font-medium mb-1">Description (optional)</label>
            <textarea name="description" id="description" rows="3" class="w-full border p-2 rounded">{{ old('description', $plan->description) }}</textarea>
            @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Update Plan</button>
    </form>
</div>
@endsection
