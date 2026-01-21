<?php

namespace App\Services;

use App\Models\FixedCost;
use App\Enums\FixedCostStatus;
use App\Models\Income;
use Illuminate\Support\Facades\Log;
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

    public function allItemOfFixedCostAndIncome(int $userId)
    {
        $income = Income::where('user_id', $userId)
             ->first();

        $fixedCost = FixedCost::where('user_id', $userId)
             ->where('status', FixedCostStatus::ACTIVE)
             ->get(['cost_name', 'amount']);

        if(!$income || $fixedCost->isEmpty()) {
            return null;
        }

        $totalFixedCost = $fixedCost->sum('amount');

        $remaining = $income->amount - $totalFixedCost;

        $series = $fixedCost->pluck('amount')->toArray();
        $labels = $fixedCost->pluck('cost_name')->toArray();

        return [
            'series' => array_merge([(float)$series] , [(float)$remaining]),
            'labels' => array_merge($labels, ['残高'])
        ];
    }
}
