<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembershipPackageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [HomeController::class, 'login'])->name('login');

Route::post('/login', [AuthController::class, 'sign_in']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::prefix("dashboard")->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::resource('membership-packages', MembershipPackageController::class);

    Route::get('/incentives', [DashboardController::class, 'incentives']);
    Route::get('/products', [DashboardController::class, 'products']);
    Route::get('/order-history', [DashboardController::class, 'order_history']);
    Route::get('/top-sales-chart', [DashboardController::class, 'top_sales_chart']);
    Route::get('/wallet-transfer-history', [DashboardController::class, 'wallet_transfer_history']);
    Route::get('/bonus-withdrawals', [DashboardController::class, 'bonus_withdrawals']);
    Route::get('/distributors', [DashboardController::class, 'distributors']);
    Route::get('/account-settings', [DashboardController::class, 'account_settings']);
});
