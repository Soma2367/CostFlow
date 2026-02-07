<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SubscriptionService;


class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function index()
    {
        $income = $this->subscriptionService->getIncome(Auth::id());
        $subscriptions = $this->subscriptionService->getSubscDataOrderByBillingDate(Auth::id());
        $countSubscriptions = $this->subscriptionService->countSubscriptions(Auth::id());
        $countActiveSubscriptions = $this->subscriptionService->countActiveSubscriptions(Auth::id());
        $rankSubscByAmount = $this->subscriptionService->rankSubscByAmount(Auth::id());
        $sum = $this->subscriptionService->sumOfSubscAmount(Auth::id());
        $chartData = $this->subscriptionService->SubscriptionChart(Auth::id());

        return view('subscriptions.index', compact(
            'income',
            'subscriptions',
            'countSubscriptions',
            'countActiveSubscriptions',
            'rankSubscByAmount',
            'sum',
            'chartData'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = SubscriptionStatus::options();
        $categories = Category::options();
        return view('subscriptions.create', compact('statuses', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
                'subscription_name' => 'required|string|max:255',
                'category' => 'required|string|max:100',
                'amount' => 'required|numeric|min:0',
                'billing_day' => 'required|integer|min:1|max:31',
                'status' => 'required|in:active,paused,stopped',
                'memo' => 'nullable|string',
        ]);

        Subscription::create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        return redirect()
            ->route('subscriptions.index')
            ->with('success', 'サブスクリプションを登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subscription = Subscription::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

        return view('subscriptions.show', compact('subscription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subscription = Subscription::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

        $statuses = SubscriptionStatus::options();
        $categories = Category::options();

        return view('subscriptions.edit', compact(
            'subscription',
            'statuses',
            'categories'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'subscription_name' => 'required|string|max:255',
             'category' => 'required|in:living,entertainment,pet,insurance,study',
            'amount' => 'required|numeric|min:0',
            'billing_day' => 'required|integer|min:1|max:31',
            'status' => 'required|in:active,paused,cancelled',
            'memo' => 'nullable|string',
        ]);

        $subscription->update($validated);

        return redirect()
            ->route('subscriptions.index')
            ->with('success', 'サブスクリプションを更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subscription = Subscription::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $subscription->delete();

        return redirect()
            ->route('subscriptions.index')
            ->with('success', 'サブスクリプションを削除しました。');
    }
}
