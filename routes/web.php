<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncentiveController;
use App\Http\Controllers\MembershipPackageController;
use App\Http\Controllers\MyTreeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [HomeController::class, 'login'])->name('login');

Route::post('/login', [AuthController::class, 'sign_in']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::prefix("dashboard")->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('account-settings', [DashboardController::class, 'account_settings']);
    Route::post('account-settings/personal', [DashboardController::class, 'change_personal']);
    Route::post('account-settings/pass-code', [DashboardController::class, 'change_password']);

    Route::get('membership-packages', [MembershipPackageController::class, 'index']);
    Route::get('membership-packages/create', [MembershipPackageController::class, 'create'])->middleware('user.admin');
    Route::post('membership-packages', [MembershipPackageController::class, 'store'])->middleware('user.admin');
    Route::get('membership-packages/{id}/edit', [MembershipPackageController::class, 'edit'])->middleware('user.admin');
    Route::put('membership-packages/{id}', [MembershipPackageController::class, 'update'])->middleware('user.admin');

    Route::get('incentives', [IncentiveController::class, 'index']);
    Route::get('incentives/create', [IncentiveController::class, 'create'])->middleware('user.admin');
    Route::post('incentives', [IncentiveController::class, 'store'])->middleware('user.admin');
    Route::get('incentives/{id}/edit', [IncentiveController::class, 'edit'])->middleware('user.admin');
    Route::put('incentives/{id}', [IncentiveController::class, 'update'])->middleware('user.admin');

    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/create', [ProductController::class, 'create'])->middleware('user.admin');
    Route::post('products', [ProductController::class, 'store'])->middleware('user.admin');
    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->middleware('user.admin');
    Route::put('products/{id}', [ProductController::class, 'update'])->middleware('user.admin');

    Route::get('order-history', [DashboardController::class, 'order_history']);
    Route::get('top-sales-chart', [DashboardController::class, 'top_sales_chart']);
    Route::get('wallet-transfer-history', [DashboardController::class, 'wallet_transfer_history'])->middleware('user.admin');
    Route::get('distributors', [DashboardController::class, 'distributors'])->middleware('user.admin');

    Route::get('my-tree', [MyTreeController::class, 'index'])->middleware('user.distributor');

    Route::get('request-withdrawal', [BonusController::class, 'request_withdrawal'])->middleware('user.distributor');
    Route::get('bonus-withdrawals', [BonusController::class, 'bonus_withdrawals'])->middleware('user.admin');
});
