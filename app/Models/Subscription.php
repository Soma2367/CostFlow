<?php

namespace App\Models;

use App\Enums\Category;
use Illuminate\Database\Eloquent\Model;
use App\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_name',
        'category',
        'amount',
        'billing_day',
        'status',
        'memo',
    ];

    protected $casts = [
        'status' => SubscriptionStatus::class,
        'category' => Category::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
