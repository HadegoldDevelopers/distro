<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;

class AdminMusicController extends Controller
{
    public function index()
    {
        $datas = Music::latest()->get();
        return view('admin.uploads', compact('datas'));
    }
    public function metadata($id)
    {
        $music = Music::findOrFail($id);
        return view('admin.metadata', compact('music'));
    }

    public function updateMetadata(Request $request, $id)
    {
        $music = Music::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'release_date' => 'required|date',
            'isrc' => 'nullable|string|max:255',
            'upc' => 'nullable|string|max:255',
            'credits' => 'nullable|string|max:500',
        ]);

        $music->update([
            'title' => $request->title,
            'artist' => $request->artist,
            'genre' => $request->genre,
            'release_date' => $request->release_date,
            'isrc' => $request->isrc,
            'upc' => $request->upc,
            'credits' => $request->credits,
        ]);

        return redirect()->route('admin.releases.all')->with('status', 'Metadata updated successfully.');
    }
    public function status($status)
    {
         $allowed = ['pending', 'approved', 'rejected'];
    if (!in_array($status, $allowed)) {
        abort(404);
    }

        $datas = Music::where('status', $status)->latest()->get();

        return view('admin.status', compact('datas', 'status'));
    }
    public function pending()
    {
        $datas = Music::where('status', 'pending')->latest()->get();
        return view('admin.status', compact('datas'))->with('status', 'pending');
    }
}
