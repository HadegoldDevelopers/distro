<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\Models\Music;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        return view('music.upload', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre' => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'cover' => 'nullable|image|max:2048',
            'audio' => 'required|mimes:mp3,wav|max:10000240',
        ]);

        $coverPath = $request->file('cover')?->store('covers', 'public');
        $audioPath = $request->file('audio')->store('songs', 'public');

        Music::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'artist' => $request->artist,
            'genre' => $request->genre,
            'release_date' => $request->release_date,
            'cover_path' => $coverPath,
            'audio_path' => $audioPath,
        ]);

        return back()->with('success', 'Music uploaded successfully!');
    }
}
