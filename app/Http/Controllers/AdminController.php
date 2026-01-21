<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $income = Income::where('user_id', Auth::id())->get();
        return view('admins.index', compact('income'));
    }
}
