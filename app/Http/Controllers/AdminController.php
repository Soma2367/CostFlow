<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use App\Services\AdminService;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index()
    {
        $income = $this->adminService->getIncome(Auth::id());
        $sumSubsc = $this->adminService->sumOfSubscription(Auth::id());
        $sumFixedCost = $this->adminService->sumOfFixedCost(Auth::id());
        $totalExpense = $sumSubsc + $sumFixedCost;
        $subscItems = $this->adminService->subScriptionItem(Auth::id());
        $fixedCostItems = $this->adminService->fixedCostItem(Auth::id());
        $adminData = $this->adminService->adminChart(Auth::id());

        return view('admins.index', compact(
            'income',
            'sumSubsc',
            'sumFixedCost',
            'totalExpense',
            'subscItems',
            'fixedCostItems',
            'adminData'
        ));
    }
}
