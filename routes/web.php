<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\FixedCostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])
        ->name('subscriptions.index');
    Route::get('/subscriptions/create', [SubscriptionController::class, 'create'])
        ->name('subscriptions.create');
    Route::post('/subscriptions/store', [SubscriptionController::class, 'store'])
        ->name('subscriptions.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/fixedCosts', [FixedCostController::class, 'index'])
        ->name('fixed-costs.index');
    Route::get('/fixedCosts/create', [FixedCostController::class, 'create'])
        ->name('fixed-costs.create');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
