@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-6">Artists</h2>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Genre</th>
                    <th class="px-4 py-2">Label</th>
                    <th class="px-4 py-2">Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($artists as $artist)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $artist->name }}</td>
                        <td class="px-4 py-2">{{ $artist->email ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $artist->genre ?? '-' }}</td>
                        <td class="px-4 py-2">
                            @if ($artist->label)
                                <div class="text-sm font-medium text-gray-800">{{ $artist->label->name }}</div>
                                <div class="text-xs text-gray-500">{{ $artist->label->email }}</div>
                            @else
                                <span class="text-gray-400 italic">None</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $artist->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center px-4 py-4 text-gray-500">No artists found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $artists->links() }}
    </div>
</div>
@endsection
