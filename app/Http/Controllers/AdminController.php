<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Artist;
use App\Models\Music;
use App\Models\Ticket;
use App\Models\Stat;


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
        $totalUsers = User::count();
        $newSignups = User::where('created_at', '>=', now()->subDays(30))->count();
        $totalReleases = Music::count();
        $pendingApprovals = Music::where('status', 'pending')->count();
        $totalRevenue = Stat::sum('earnings');
        $openTickets = Ticket::where('status', 'open')->count();

        // Album uploads by date for the last 30 days
        $recentMusic = Music::where('created_at', '>=', now()->subDays(30))->get();

        $albumUploads = $recentMusic->groupBy(fn($music) => $music->created_at->toDateString())
            ->map(fn($group) => $group->count())
            ->sortKeys()
            ->toArray();

        // Top earning artists (from stats, grouped by user)
        $topArtists = Stat::with('user:id,artist_name')
            ->get()
            ->groupBy('user_id')
            ->map(function ($stats) {
                return [
                    'user' => $stats->first()->user,
                    'total_earnings' => $stats->sum('earnings'),
                ];
            })
            ->sortByDesc('total_earnings')
            ->take(5)
            ->values();

        // Most streamed music (from stats, grouped by music)
        $mostStreamed = Stat::with('music.artist')
            ->get()
            ->groupBy('music_id')
            ->map(function ($stats) {
                return [
                    'music' => $stats->first()->music,
                    'total_streams' => $stats->sum('streams'),
                ];
            })
            ->sortByDesc('total_streams')
            ->take(5)
            ->values();

        // Recent uploads
        $recentUploads = Music::with('artist')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'newSignups',
            'totalReleases',
            'pendingApprovals',
            'totalRevenue',
            'openTickets',
            'albumUploads',
            'topArtists',
            'mostStreamed',
            'recentUploads'
        ));
    }

    public function labels()
    {
        $todayDate = date('Y-m-d');
        $last7DaysDate = date('Y-m-d', strtotime('-7 days'));

        $todaySignups = User::whereDate('created_at', $todayDate)->get();

        $last7DaysSignups = User::whereDate('created_at', '>=', $last7DaysDate)->get();

        $activeUsers = User::where('is_active', true)->get();

        $allLabels = User::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users.labels', compact(
            'todaySignups',
            'last7DaysSignups',
            'activeUsers',
            'allLabels'
        ));
    }

    

    public function artists()
    {
        $artists = Artist::with('label')->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users.artist', compact('artists'));
    }


    public function approveMusic($id)
    {
        $music = Music::findOrFail($id);
        $music->status = 'approved';
        $music->save();
        return redirect()->back()->with('success', 'Music approved.');
    }

    public function rejectMusic($id)
    {
        $music = Music::findOrFail($id);
        $music->status = 'rejected';
        $music->save();
        return redirect()->back()->with('error', 'Music rejected.');
    }
    public function updateEarnings(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $user->earnings = $request->earnings;
        $user->save();

        return back()->with('success', 'Earnings updated successfully');
    }
}

