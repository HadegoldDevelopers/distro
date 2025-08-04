<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stat;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class RoyaltiesController extends Controller
{ 
    protected array $unmatchedArtists = [];

    
    // Show upload form (optional)
    public function reports(Request $request)
    {
        $query = Stat::query();

        // Optional filters
        switch ($request->input('range')) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'month':
                $query->whereMonth('created_at', now()->month);
                break;
        }

        $stats = [
            'total_earnings' => $query->sum('earnings'),
            'total_streams'  => $query->sum('streams'),
            'artist_payout'  => $query->whereHas('user', fn($q) => $q->where('role', 'artist'))->sum('earnings'),
            'label_payout'   => $query->whereHas('user', fn($q) => $q->where('role', 'label'))->sum('earnings'),
            'track_count'    => $query->distinct('music_id')->count('music_id'),
            'countries'      => $query->distinct('country')->count('country'),
        ];

       return view('admin.royalties.index', compact('stats'));
    }

    public function royaltiesReport()
    {
        return view('admin.royalties.reports.royalties');
    }

    public function streamsReport()
    {
        return view('admin.royalties.reports.streams');
    }

    public function earningsReport()
    {
        return view('admin.royalties.reports.earnings');
    }

    public function payouts()
    {
        return view('admin.royalties.payouts');
    }


    public function uploadReport(Request $request)
    {
        $request->validate([
            'distributor' => 'required|in:soundrop,horus,cdbaby,distrokid,vydia',
            'earnings_csv' => 'required|file|mimes:csv,txt',
        ]);

        $path = $request->file('earnings_csv')->store('temp', 'private');
        $fullPath = storage_path('app/private/' . $path);

        if (!file_exists($fullPath)) {
            return redirect()->back()->with('error', 'Uploaded file not found at: ' . $fullPath);
        }

        match ($request->distributor) {
            'soundrop'  => $this->parseSoundrop($fullPath),
            'horus'     => $this->parseHorus($fullPath),
            'cdbaby'    => $this->parseCDBaby($fullPath),
            'distrokid' => $this->parseDistroKid($fullPath),
            'vydia'     => $this->parseVydia($fullPath),
            default     => $this->parseAuto($fullPath),
        };


        Storage::delete($path);

        $message = 'Royalties report processed.';
        if (!empty($this->unmatchedArtists)) {
            $message .= ' Some artists could not be matched: ' . implode(', ', array_unique($this->unmatchedArtists));
        }

        return redirect()->route('admin.royalties.reports')->with('success', $message);
    }
    protected function parseAuto(string $path): void
    {
        $csv = \League\Csv\Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);
        $headers = $csv->getHeader();

        foreach ($csv->getRecords() as $row) {
            $normalized = $this->normalizeCsvRow($row, $headers);
            if (!$normalized) {
                continue;
            }

            $this->saveStat(
                $normalized['artist'],
                $normalized['track'],
                $normalized['streams'],
                $normalized['amount'],
                $normalized['store'],
                $normalized['country'],
                $normalized['year'],
                $normalized['month'],
                $normalized['isrc'],
                $normalized['upc']
            );
        }
    }

    protected function parseSoundrop(string $path): void
    {
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv->getRecords() as $row) {
            $artist = trim($row['Artist'] ?? '');
            $track = trim($row['Track Title'] ?? '');
            $amount = floatval($row['Amount Due in USD'] ?? 0);
            $streams = intval($row['Quantity'] ?? 0);
            $store = $row['Service'] ?? 'Soundrop';
            $country = $row['Country'] ?? 'Unknown';
            $month = date('m', strtotime($row['Transaction Month'] ?? now()));
            $year = date('Y', strtotime($row['Transaction Month'] ?? now()));
            $isrc = trim($row['ISRC'] ?? null);
            $upc = trim($row['UPC'] ?? null);

            $this->saveStat($artist, $track, $streams, $amount, $store, $country, $year, $month, $isrc, $upc);
        }
    }

    protected function parseHorus(string $path): void
    {
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(3); // Real headers start on row 4

        foreach ($csv->getRecords() as $row) {
            $artist     = trim($row['Track Artist(s)'] ?? '');
            $track      = trim($row['Track Title'] ?? '');
            $amount     = floatval($row['Artists Amount (£)'] ?? 0); // Use correct earnings field
            $streams    = intval($row['Quantity'] ?? 0);
            $store      = trim($row['Store'] ?? 'Horus');
            $country    = strtoupper(substr(trim($row['Country Of Sale'] ?? 'XX'), 0, 2)); // 2-char country code
            $date       = trim($row['Date Of Sale'] ?? now());
            $year       = date('Y', strtotime($date));
            $month      = date('m', strtotime($date));
            $isrc       = trim($row['ISRC'] ?? '');
            $upc        = trim($row['Barcode'] ?? '');

            $this->saveStat(
                $artist,
                $track,
                $streams,
                $amount,
                $store,
                $country,
                $year,
                $month,
                $isrc,
                $upc
            );
        }
    }
    protected function parseCDBaby(string $path): void
    {
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);
        foreach ($csv->getRecords() as $row) {
            $artist = trim($row['Track Artist'] ?? '');
            $track = trim($row['Track Title'] ?? '');
            $upc = trim($row['UPC'] ?? '');
            $isrc = trim($row['ISRC'] ?? '');
            $streams = intval($row['Units Sold'] ?? $row['Count'] ?? 0);
            $amount = floatval($row['Gross Revenue'] ?? $row['Net Revenue'] ?? 0);
            $country = trim($row['Territory'] ?? $row['Sale Country'] ?? '');
            $store = 'CD Baby';
            $month = date('m', strtotime($row['Statement Period'] ?? now()));
            $year = date('Y', strtotime($row['Statement Period'] ?? now()));

            $this->saveStat($artist, $track, $streams, $amount, $store, $country, $year, $month, $isrc, $upc);
        }
    }

protected function parseDistroKid(string $path): void
{
    $csv = Reader::createFromPath($path, 'r');
    $csv->setHeaderOffset(0);

    foreach ($csv->getRecords() as $row) {
        $artist     = trim($row['TRACK ARTIST'] ?? $row['Track Artist'] ?? '');
        $track      = trim($row['TRACK'] ?? '');
        $upc        = trim($row['DISPLAY UPC'] ?? $row['UPC'] ?? '');
        $isrc       = trim($row['ISRC'] ?? '');
        $streams    = intval($row['UNITS SOLD'] ?? $row['Count'] ?? 0);
        $amount     = floatval($row['GROSS REVENUE ACCOUNT CURRENCY'] ?? $row['Net Revenue'] ?? 0);
        $country    = trim($row['TERRITORY'] ?? $row['Sale Country'] ?? '');
        $store      = trim($row['Digital Service Provider'] ?? 'DistroKid');
        $month      = date('m', strtotime($row['STATEMENT PERIOD'] ?? now()));
        $year       = date('Y', strtotime($row['STATEMENT PERIOD'] ?? now()));

        $this->saveStat($artist, $track, $streams, $amount, $store, $country, $year, $month, $isrc, $upc);
    }
}
protected function parseVydia(string $path): void
{
    $csv = Reader::createFromPath($path, 'r');
    $csv->setHeaderOffset(0); // Adjust if their file has header rows

    foreach ($csv->getRecords() as $row) {
        $artist    = trim($row['Artist'] ?? $row['Track Artist'] ?? '');
        $track     = trim($row['Track Title'] ?? $row['Title'] ?? '');
        $upc       = trim($row['UPC'] ?? '');
        $isrc      = trim($row['ISRC'] ?? '');
        $streams   = intval($row['Play Count'] ?? $row['Streams'] ?? 0);
        $amount    = floatval($row['Revenue'] ?? $row['Net Revenue'] ?? 0);
        $country   = trim($row['Country'] ?? '');
        $store     = trim($row['Platform'] ?? 'Vydia');
        $month     = date('m', strtotime($row['Date'] ?? now()));
        $year      = date('Y', strtotime($row['Date'] ?? now()));

        $this->saveStat($artist, $track, $streams, $amount, $store, $country, $year, $month, $isrc, $upc);
    }
}
    protected function normalizeCsvRow(array $row, array $headers): ?array
    {
        $map = [
            'artist' => ['artist', 'track artist', 'artist name'],
            'track' => ['title', 'track title', 'song title'],
            'isrc' => ['isrc'],
            'upc' => ['upc', 'barcode'],
            'streams' => ['streams', 'play count', 'quantity'],
            'amount' => ['revenue', 'net revenue', 'label amount (£)', 'amount due in usd'],
            'store' => ['store', 'platform', 'service'],
            'country' => ['country', 'country of sale'],
            'date' => ['date', 'transaction month', 'date of sale'],
        ];

        $get = function (array $keys) use ($row) {
            foreach ($keys as $key) {
                foreach ($row as $header => $value) {
                    if (stripos($header, $key) !== false) {
                        return trim($value);
                    }
                }
            }
            return null;
        };

        $artist = $get($map['artist']);
        $track = $get($map['track']);
        if (!$artist || !$track) return null;

        $date = $get($map['date']) ?? now();
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));

        return [
            'artist' => $artist,
            'track' => $track,
            'isrc' => $get($map['isrc']),
            'upc' => $get($map['upc']),
            'streams' => intval($get($map['streams']) ?? 0),
            'amount' => floatval($get($map['amount']) ?? 0),
            'store' => $get($map['store']) ?? 'Unknown',
            'country' => $get($map['country']) ?? '',
            'year' => $year,
            'month' => $month,
        ];
    }


    protected function saveStat(string $artistName, string $trackTitle, int $streams, float $amount, string $store, string $country, string $year, string $month, ?string $isrc, ?string $upc): void
    {
        if (!$artistName) return;

        $user = match_artist_user($artistName);

        if (!$user) {
            $this->unmatchedArtists[] = "$artistName - $trackTitle";
            return;
        }

        // Try matching music by title, then by ISRC or UPC
        $music = $user->music()
            ->where('title', $trackTitle)
            ->orWhere('isrc', $isrc)
            ->orWhere('upc', $upc)
            ->first();

        if (!$music) {
            $this->unmatchedArtists[] = "$artistName - $trackTitle";
            return;
        }

        Stat::updateOrCreate(
            [
                'user_id'   => $user->id,
                'music_id'  => $music->id,
                'year'      => $year,
                'month'     => $month,
                'store'     => $store,
                'country'   => $country,
                'quality'   => 'standard',
            ],
            [
                'streams'   => $streams,
                'earnings'  => $amount,
            ]
        );
    }
}


