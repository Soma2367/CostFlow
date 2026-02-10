<?php

namespace App\Services;

use App\Enums\SubscriptionStatus;
use App\Enums\FixedCostStatus;
use App\Models\FixedCost;
use App\Models\Income;
use App\Models\Subscription;

class AdminService
{
    public function getIncome(int $userId) {
        return Income::where('user_id', $userId)->first();
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

    public function adminChart(int $userId) {
        $income = Income::where('user_id', $userId)
             ->first('amount');

        $subscriptions = Subscription::where('user_id', $userId)
                    ->where('status', SubscriptionStatus::ACTIVE)
                    ->get(['subscription_name', 'amount']);

        $fixedCosts = FixedCost::where('user_id', $userId)
                    ->where('status', FixedCostStatus::ACTIVE)
                    ->get(['cost_name', 'amount']);

        if(!$income || ($subscriptions->isEmpty() && $fixedCosts->isEmpty())) {
            return null;
        }

        $subscExpense = $subscriptions->sum('amount');
        $fixedCostExpense = $fixedCosts->sum('amount');
        $totalExpense = $subscExpense + $fixedCostExpense;

        $balance = $income->amount - $totalExpense;

        if($balance <= 0) {
            return null;
        }

        if($balance > 0) {
            $series[] = $balance;
            $labels[] = '残高';
        }

        $subscLabel = $subscriptions->pluck('subscription_name')->toArray();
        $subscAmount = $subscriptions->pluck('amount')->toArray();

        $fixedCostLabel = $fixedCosts->pluck('cost_name')->toArray();
        $fixedCostAmount = $fixedCosts->pluck('amount')->toArray();

        $result = [
            'series' => array_merge($subscAmount, $fixedCostAmount, $series ?? []),
            'labels' => array_merge($subscLabel, $fixedCostLabel, $labels ?? [])
        ];

        // dump($result);
        return $result;
    }
}
