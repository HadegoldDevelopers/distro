<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artist extends Model
{
    public function label()
    {
        return $this->belongsTo(User::class);
    }
    public function music()
    {
        return $this->hasMany(Music::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'name',
        'email',
        'bio',
        'genre',
        'website',
        'profile_image',
        'country',
        'social_facebook',
        'social_twitter',
        'social_instagram',
        'contact_phone',
        'audiomack_id',
        'spotify_id',
        'apple_music_id',
        'user_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];}
