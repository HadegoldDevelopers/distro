<?php

namespace App\Models;

use App\Models\Music;
use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Get the music uploads for the user.
     */
    public function music(): HasMany
    {
        return $this->hasMany(Music::class);
    }
    public function artists()
    {
        return $this->hasMany(Artist::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',

        // Withdrawal-related fields
        'bank_name',
        'account_number',
        'account_name',
        'paypal_email',
        'crypto_wallet',
        'crypto_type',

        // User settings fields:
        'artist_name',
        'user_audiomack',
        'user_profileimage',
        'user_spotify',
        'user_applemusic_id',
        'email_notifications',
        'dark_mode',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
