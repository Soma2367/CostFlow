<?php

namespace App\Services;

use App\Models\Subscription;
use App\Enums\SubscriptionStatus;
class SubscriptionService
{
    public function getSubscDataOrderByBillingDate(int $userId)
    {
        return Subscription::where('user_id', $userId)
            ->orderBy('billing_day', 'asc')
            ->get();
    }

    public function countSubscriptions(int $userId)
    {
        return Subscription::where('user_id', $userId)->count();
    }

    public function countActiveSubscriptions(int $userId)
    {
        return Subscription::where('user_id', $userId)
            ->where('status', 'active')
            ->count();
    }

    public function rankSubscByAmount(int $userId)
    {
        return Subscription::where('user_id', $userId)
            ->orderBy('amount', 'desc')
            ->take(3)
            ->get();
    }

    public function sumOfSubscAmount(int $userId)
    {
        return Subscription::where('user_id', $userId)
            ->where('status', SubscriptionStatus::ACTIVE)
            ->sum('amount');
    }
}
