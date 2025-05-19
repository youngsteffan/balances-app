<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\OperationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Main pages
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/history', function () {
        return Inertia::render('History');
    })->name('history');

    // API
    Route::prefix('api')->group(function () {
        Route::get('/balance', [BalanceController::class, 'getBalance']);
        Route::get('/operations', [OperationController::class, 'index']);
        Route::get('/operations/latest', [OperationController::class, 'latest']);
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
