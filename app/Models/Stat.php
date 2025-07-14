<?php

// app/Models/Stat.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $fillable = ['year', 'month', 'music_id', 'store', 'country', 'quality', 'streams', 'user_id', 'earnings'];

    public function music()
    {
        return $this->belongsTo(Music::class);
    }
}
