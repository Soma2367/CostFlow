<?php

namespace App\Services;

use App\Enums\SubscriptionStatus;
use App\Enums\FixedCostStatus;
use App\Models\FixedCost;
use App\Models\Income;
use App\Models\Subscription;

class AdminService
{
    public function getIncome(int $useId) {
        return Income::where('user_id', $useId)->get();
    }

    public function subScriptionItem(int $userId) {
        return Subscription::where('user_id', $userId)
            ->orderBy('amount', 'desc')
            ->take(5)
            ->get();
    }

    public function fixedCostItem(int $userId) {
        return FixedCost::where('user_id', $userId)
            ->orderBy('amount', 'desc')
            ->take(5)
            ->get();
    }

    public function sumOfSubscription(int $userId) {
        return Subscription::where('user_id', $userId)
            ->where('status', SubscriptionStatus::ACTIVE)
            ->sum('amount');
    }

    public function sumOfFixedCost(int $userId) {
        return FixedCost::where('user_id', $userId)
            ->where('status', FixedCostStatus::ACTIVE)
            ->sum('amount');
    }
}
