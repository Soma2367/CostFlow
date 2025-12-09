<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\SubscriptionStatus;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_name',
        'category',
        'amount',
        'billing_day',
        'status',
        'notes',
    ];

    protected $casts = [
        'status' => SubscriptionStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
