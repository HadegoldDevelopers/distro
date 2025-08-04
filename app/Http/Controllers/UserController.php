<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Stat;
use App\Models\Music;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;



class UserController extends Controller
{
    public function userDashboard()
    {
        $user = Auth::user();
        $siteTitle = Setting::getValue('site_title', 'Default Site Title');
        $totalArtists = $user->artists()->count();

        $last30Days = now()->subDays(30);

        $totalStreams = Stat::where('user_id', $user->id)
            ->where('created_at', '>=', $last30Days)
            ->sum('streams');

        $totalEarnings = Stat::where('user_id', $user->id)
            ->where('created_at', '>=', $last30Days)
            ->sum('earnings');

        $submittedSongs = $user->music()->count();
        $approvedSongs = $user->music()->where('status', 'approved')->count();

        $startOfThisMonth = Carbon::now()->startOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        $thisMonthUploads = $user->music()->where('created_at', '>=', $startOfThisMonth)->count();
        $lastMonthUploads = $user->music()
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();

        $percentChange = 0;
        if ($lastMonthUploads > 0) {
            $percentChange = (($thisMonthUploads - $lastMonthUploads) / $lastMonthUploads) * 100;
        } elseif ($thisMonthUploads > 0) {
            $percentChange = 100;
        }

        $musics = $user->music()->latest()->take(5)->get();


        $streamChartData = Stat::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw("SUM(streams) as total_streams")
        )
            ->where('user_id', $user->id)
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->orderBy('month')
            ->get();


        return view('dashboard', [
            'user' => $user,
            'siteTitle' => $siteTitle,
            'submittedSongs' => $submittedSongs,
            'approvedSongs' => $approvedSongs,
            'musics' => $musics,
            'percentChange' => round($percentChange, 2),
            'totalStreams' => $totalStreams,
            'totalEarnings' => round($totalEarnings, 2),
            'streamChartData' => $streamChartData,
            'totalArtists' => $totalArtists,

        ]);
    }

    public function release()
    { 
            $user = Auth::user();

        $artistIds = $user->artists->pluck('id');

        $releases = Music::with(['artist', 'user'])
            ->where(function ($query) use ($user, $artistIds) {
                $query->where('user_id', $user->id);
                
            })
            ->latest()
            ->paginate(10);

            return view('music.releases', compact('releases', 'user'));
        }
    public function settings()
    {
        $user = Auth::user();
        return view('user.settings', compact('user'));
    }
    public function updateSettings(Request $request)
    {
        try {
            $request->validate([
            'artist_name' => 'nullable|string|max:255',
            'user_profileimage' => 'nullable|image|max:500', 
            'user_audiomack' => 'nullable|string|max:255',
            'user_spotify' => 'nullable|string|max:255',
            'user_applemusic_id' => 'nullable|string|max:255',
            'email_notifications' => 'nullable|boolean',
            'dark_mode' => 'nullable|boolean',
        ]);

        $user = User::find(Auth::id());

        $user->artist_name = $request->artist_name;
        
        if ($request->hasFile('user_profileimage')) {
            $profileImagePath = $request->file('user_profileimage')->store('profile_images', 'public');
            $user->user_profileimage = $profileImagePath;
        }

        $user->user_audiomack = $request->user_audiomack;
        $user->user_spotify = $request->user_spotify;
        $user->user_applemusic_id = $request->user_applemusic_id;
        $user->email_notifications = $request->email_notifications;
        $user->dark_mode = $request->dark_mode;
        

        $user->save();

        return back()->with('success', 'Settings updated successfully!');
    } catch (\Exception $e) {
        return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
    }
}