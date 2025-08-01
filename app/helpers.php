<?php
use App\Helpers\ArtistMatcher; 



if (!function_exists('match_artist_user')) {
    /**
     * Helper function to find user by artist name or IDs.
     */
    function match_artist_user(string $artistName, ?string $spotifyId = null, ?string $appleId = null)
    {
        return ArtistMatcher::matchArtistUser($artistName, $spotifyId, $appleId);
    }
}
