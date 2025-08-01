@extends('layouts.admin')

@section('title', 'Royalties Reports Dashboard')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-indigo-700 mb-6">Royalties Dashboard</h1>

        <div class="bg-white shadow rounded-lg p-6 space-y-4">
            <div>
                <h2 class="text-lg font-semibold mb-2">Reports</h2>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.royalties.reports.royalties') }}"
                           class="text-indigo-600 hover:underline">
                            📄 Royalties Report
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.royalties.reports.streams') }}"
                           class="text-indigo-600 hover:underline">
                            🎧 Streams Report
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.royalties.reports.earnings') }}"
                           class="text-indigo-600 hover:underline">
                            💰 Earnings Report
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-2">Upload Earnings CSV</h2>
                <form action="{{ route('admin.royalties.reports.upload') }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto p-4 bg-white rounded shadow">
    @csrf

    <label for="distributor" class="block mb-2 font-semibold">Choose Distributor:</label>
    <select name="distributor" id="distributor" required class="w-full p-2 border rounded mb-4">
        <option value="">-- Select Distributor --</option>
        <option value="default">Auto Detect </option>
        <option value="distrokid">DistroKid</option>
        <option value="soundrop">Soundrop</option>
        <option value="horus">Horus Music</option>
        <option value="vydia">Vydia</option>
        <option value="cdbaby">CD Baby</option>
    </select>

    <label for="earnings_csv" class="block mb-2 font-semibold">Upload CSV Report:</label>
    <input type="file" name="earnings_csv" id="earnings_csv" required class="w-full mb-4">

    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Upload</button>
</form>

            </div>
        </div>
    </div>
@endsection
