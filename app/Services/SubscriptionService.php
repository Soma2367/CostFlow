<?php

namespace App\Services;

use App\Models\Subscription;

class SubscriptionService
{
    public function getSubscDataOrderByBillingDate(int $userId)
    {
        return Subscription::where('user_id', $userId)
            ->orderBy('billing_day', 'asc')
            ->get();
    }
}
