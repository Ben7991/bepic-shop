<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [HomeController::class, 'login'])->name('login');

Route::post('/login', [AuthController::class, 'sign_in']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::prefix("dashboard")->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/membership-packages', [DashboardController::class, 'membership_packages']);
    Route::get('/incentives', [DashboardController::class, 'incentives']);
    Route::get('/products', [DashboardController::class, 'products']);
    Route::get('/order-history', [DashboardController::class, 'order_history']);
    Route::get('/top-sales-chart', [DashboardController::class, 'top_sales_chart']);
    Route::get('/wallet-transfer-history', [DashboardController::class, 'wallet_transfer_history']);
    Route::get('/bonus-withdrawals', [DashboardController::class, 'bonus_withdrawals']);
    Route::get('/distributors', [DashboardController::class, 'distributors']);
    Route::get('/account-settings', [DashboardController::class, 'account_settings']);
});
