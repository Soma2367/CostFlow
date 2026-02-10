<?php

namespace App\Services;

use App\Models\FixedCost;
use App\Enums\FixedCostStatus;
use App\Models\Income;
class FixedCostService
{
    public function getIncome(int $userId) {
        return Income::where('user_id', $userId)->first();
    }

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
        $balance = $income->amount - $totalFixedCost;

        if($balance <= 0) {
            return null;
        }

        $remaining_series = [];
        $remaining_labels = [];

        if($balance > 0) {
            $remaining_series[] = $balance;
            $remaining_labels[] = '残高';
        }

        $series = $fixedCost->pluck('amount')->toArray();
        $labels = $fixedCost->pluck('cost_name')->toArray();
        // dump($series);

        $result = [
            'series' => array_merge($series, $remaining_series),
            'labels' => array_merge($labels, $remaining_labels),
        ];
        // dump($result);

        return $result;
    }
}
