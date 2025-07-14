<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Music;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $users = User::count();
        $songs = Music::count();
        return view('admin.dashboard', compact('users', 'songs'));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function songs()
    {
        $songs = Music::latest()->get();
        return view('admin.uploads', compact('songs'));
    }

    public function approveSong($id)
    {
        $song = Music::findOrFail($id);
        $song->status = 'approved';
        $song->save();
        return redirect()->back()->with('success', 'Song approved.');
    }

    public function rejectSong($id)
    {
        $song = Music::findOrFail($id);
        $song->status = 'rejected';
        $song->save();
        return redirect()->back()->with('error', 'Song rejected.');
    }
    public function updateEarnings(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $user->earnings = $request->earnings;
        $user->save();

        return back()->with('success', 'Earnings updated successfully');
    }
}

