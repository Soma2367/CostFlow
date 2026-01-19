<?php

namespace App\Http\Controllers;

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
        $fixedCosts = $this->fixedCostService->getCostDataOrderByBillingDate(Auth::id());
        $countFixedCosts = $this->fixedCostService->countFixedCost(Auth::id());
        $countActiveFixedCosts = $this->fixedCostService->countActiveFixedCost(Auth::id());
        $rankFixedCostByAmount = $this->fixedCostService->rankFixedCostByAmount(Auth::id());
        $sum = $this->fixedCostService->sumOfFixedAmount(Auth::id());

        return view('fixed-costs.index', compact(
            'fixedCosts',
            'countFixedCosts',
            'countActiveFixedCosts',
            'rankFixedCostByAmount',
            'sum'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuese = FixedCostStatus::cases();
        return view('fixed-costs.create', compact('statuese'));
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
            'category' => 'required|string|max:100',
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
    public function show(string $id)
    {
        $fixedCost = FixedCost::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('fixed-costs.show', compact('fixedCost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fixedCost = FixedCost::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $statuese = FixedCostStatus::cases();

        return view('fixed-costs.edit', compact('fixedCost', 'statuese'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FixedCost $fixedCost)
    {
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
    public function destroy(string $id)
    {
        $fixedCost = FixedCost::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $fixedCost->delete();

        return redirect()
            ->route('fixed-costs.index')
            ->with('success', '固定費を削除しました。');
    }
}
