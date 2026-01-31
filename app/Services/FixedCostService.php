<?php

namespace App\Services;

use App\Models\FixedCost;
use App\Enums\FixedCostStatus;
use App\Models\Income;
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
            ->get()
            ->values();
    }

    public function sumOfFixedAmount(int $userId)
    {
        return FixedCost::where('user_id', $userId)
            ->where('status', FixedCostStatus::ACTIVE)
            ->sum('amount');
    }

    public function FixedCostChart(int $userId)
    {
        $income = Income::where('user_id', $userId)
             ->first(['amount']);

        $fixedCost = FixedCost::where('user_id', $userId)
             ->where('status', FixedCostStatus::ACTIVE)
             ->get(['cost_name', 'amount']);

        if(!$income || $fixedCost->isEmpty()) {
            return null;
        }

        $totalFixedCost = $fixedCost->sum('amount');

        $remaining = $income->amount - $totalFixedCost;

        $series = $fixedCost->pluck('amount')
                            ->map(fn($amount) => (float)$amount)
                            ->toArray();
        $labels = $fixedCost->pluck('cost_name')->toArray();
        // dump($series);

        $result = [
            'series' => array_merge($series, [(float)$remaining]),
            'labels' => array_merge($labels, ['残高'])
        ];
        // dump($result);

        return $result;
    }
}
