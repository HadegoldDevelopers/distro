{{-- Flash messages --}}
@if (session('success'))
    <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

{{-- Validation errors --}}
@if ($errors->any())
    <div class="bg-red-600 text-white p-4 rounded mb-4">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
