<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = ['name', 'role', 'price', 'billing_cycle', 'description', 'currency'];
}
