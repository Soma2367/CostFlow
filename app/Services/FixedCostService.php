<?php

namespace App\Services;

use App\Models\FixedCost;
use App\Enums\FixedCostStatus;

class FixedCostService
{
    public function getCostDataOrderByBillingDate(int $userId)
    {
        return FixedCost::where('user_id', $userId)
            ->orderBy('billing_day', 'asc')
            ->get();
    }

    public function countFixedCost(int $userId)
    {
        return FixedCost::where('user_id', $userId)->count();
    }

    public function countActiveFixedCost(int $userId)
    {
        return FixedCost::where('user_id', $userId)
            ->where('status', FixedCostStatus::ACTIVE)
            ->count();
    }

    public function rankFixedCostByAmount(int $userId)
    {
        return FixedCost::where('user_id', $userId)
            ->orderBy('amount', 'desc')
            ->take(3)
            ->get();
    }

    public function sumOfFixedAmount(int $userId)
    {
        return FixedCost::where('user_id', $userId)
            ->where('status', FixedCostStatus::ACTIVE)
            ->sum('amount');
    }
}
