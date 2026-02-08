<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Enums\FixedCostStatus;
use App\Models\FixedCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FixedCostService;

class FixedCostController extends Controller
{
    protected $fixedCostService;

    public function __construct(FixedCostService $fixedCostService)
    {
        $this->fixedCostService = $fixedCostService;
    }

    public function index()
    {
        $income = $this->fixedCostService->getIncome(Auth::id());
        $fixedCosts = $this->fixedCostService->getCostDataOrderByBillingDate(Auth::id());
        $countFixedCosts = $this->fixedCostService->countFixedCost(Auth::id());
        $countActiveFixedCosts = $this->fixedCostService->countActiveFixedCost(Auth::id());
        $rankFixedCostByAmount = $this->fixedCostService->rankFixedCostByAmount(Auth::id());
        $sumFixedCost = $this->fixedCostService->sumOfFixedAmount(Auth::id());

        $chartData = $this->fixedCostService->FixedCostChart(Auth::id());

        return view('fixed-costs.index', compact(
            'income',
            'fixedCosts',
            'countFixedCosts',
            'countActiveFixedCosts',
            'rankFixedCostByAmount',
            'sumFixedCost',
            'chartData'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = FixedCostStatus::options();
        $categories = Category::options();

        return view('fixed-costs.create', compact('statuses', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cost_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'billing_day' => 'required|integer|min:1|max:31',
            'category' => 'required|in:living,entertainment,pet,insurance,study',
            'status' => 'required|in:active,inactive',
            'memo' => 'nullable|string',
        ]);

        FixedCost::create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        return redirect()
            ->route('fixed-costs.index')
            ->with('success', '固定費を登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(FixedCost $fixedCost)
    {
        if($fixedCost->user_id !== Auth::id()) {
            abort(403);
        };

        return view('fixed-costs.show', compact('fixedCost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FixedCost $fixedCost)
    {
        if($fixedCost->user_id !== Auth::id()) {
            abort(403);
        };

        $statuses = FixedCostStatus::options();
        $categories = Category::options();

        return view('fixed-costs.edit', compact('fixedCost', 'statuses', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FixedCost $fixedCost)
    {
        if($fixedCost->user_id !== Auth::id()) {
            abort(403);
        };

        $validated = $request->validate([
            'cost_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'amount' => 'required|numeric|min:0',
            'billing_day' => 'required|integer|min:1|max:31',
            'status' => 'required|in:active,inactive',
            'memo' => 'nullable|string',
        ]);

        $fixedCost->update($validated);

        return redirect()
            ->route('fixed-costs.index')
            ->with('success', '固定費を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FixedCost $fixedCost)
    {
        if($fixedCost->user_id !== Auth::id()) {
            abort(403);
        };

        $fixedCost->delete();

        return redirect()
            ->route('fixed-costs.index')
            ->with('success', '固定費を削除しました。');
    }
}
