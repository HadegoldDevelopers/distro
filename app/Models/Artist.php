<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function music()
    {
        return $this->hasMany(Music::class);
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
