<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use Illuminate\Support\Facades\Auth;

class ArtistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $artists = $user->artists()->latest()->paginate(10);

        return view('artists.index', compact('artists', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('artists.create', compact('user'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:artists,email',
            'bio' => 'nullable|string',
            'genre' => 'nullable|string|max:255',
            'profile_image' => 'nullable|string|max:255',
            'audiomack_id' => 'nullable|string|max:255',
            'spotify_id' => 'nullable|string|max:255',
            'apple_music_id' => 'nullable|string|max:255',
        ]);

        $data['user_id'] = Auth::id();

        Artist::create($data);

        return redirect()->route('artists.index')->with('success', 'Artist added successfully.');
    }

    public function edit(Artist $artist)
    {
        $user = Auth::user();
        // Make sure the authenticated user owns this artist
        if ($artist->user_id !== Auth::id()) {
            abort(403);
        }

        return view('artists.edit', compact('artist', 'user'));
    }

    public function update(Request $request, Artist $artist)
    {
        if ($artist->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "nullable|email|unique:artists,email,{$artist->id}",
            'bio' => 'nullable|string',
            'genre' => 'nullable|string|max:255',
            'profile_image' => 'nullable|string|max:255',
            'audiomack_id' => 'nullable|string|max:255',
            'spotify_id' => 'nullable|string|max:255',
            'apple_music_id' => 'nullable|string|max:255',
        ]);

        $artist->update($data);

        return redirect()->route('artists.index')->with('success', 'Artist updated successfully.');
    }
}
