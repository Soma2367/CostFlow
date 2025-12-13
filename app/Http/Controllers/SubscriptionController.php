<?php

namespace App\Http\Controllers;

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
        $subscriptions = $this->subscriptionService->getSubscDataOrderByBillingDate(Auth::id());

        return view('subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuese = SubscriptionStatus::cases();  // statuese のまま
        return view('subscriptions.create', compact('statuese'));
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

        return redirect()->route('subscriptions.index')->with('success', 'サブスクリプションを登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
