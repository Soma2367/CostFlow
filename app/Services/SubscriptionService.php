<?php

namespace App\Services;

use App\Models\Subscription;
use App\Enums\SubscriptionStatus;
use App\Models\Income;
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

    public function allItemOfSubscAndIncome(int $userId) {
        $income = Income::where('user_id', $userId)
             ->first(['amount']);

        $subscriptions = Subscription::where('user_id', $userId)
                    ->where('status', SubscriptionStatus::ACTIVE)
                    ->get(['subscription_name', 'amount']);

        if(!$income || $subscriptions->isEmpty()) {
            return null;
        }

        $totalSubsc = $subscriptions->sum('amount');
        $balance = $income->amount - $totalSubsc;
        // dump($balance);

        $series = $subscriptions->pluck('amount')
                                ->map(fn($amount) => (float)$amount)
                                ->toArray();

        $labels = $subscriptions->pluck('subscription_name')->toArray();
        // dump($labels, $series);

        $result = [
            'series' => array_merge($series, [(float)$balance]),
            'labels' => array_merge($labels, ['残高'])
        ];
        // dump($result);

        return $result;
    }
}
