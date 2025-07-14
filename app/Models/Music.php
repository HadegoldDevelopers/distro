<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'artist',
        'genre',
        'release_date',
        'cover_path',
        'audio_path',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
