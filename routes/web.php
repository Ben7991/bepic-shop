<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributorController;
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
    Route::get('products/{id}', [ProductController::class, 'show'])->middleware('user.distributor');
    Route::post('products/{id}/purchase', [ProductController::class, 'purchase'])->middleware('user.distributor');

    Route::get('order-history', [DashboardController::class, 'order_history'])->middleware('user.admin');
    Route::put('order-history/{id}/approve', [DashboardController::class, 'approve_order'])->middleware('user.admin');
    Route::get('purchase-history', [DashboardController::class, 'purchase_history'])->middleware('user.distributor');

    Route::get('top-sales-chart', [DashboardController::class, 'top_sales_chart']);

    Route::get('distributors', [DistributorController::class, 'index'])->middleware('user.admin');
    Route::get('distributors/create', [DistributorController::class, 'create'])->middleware('user.admin');
    Route::post('distributors', [DistributorController::class, 'store'])->middleware('user.admin');
    Route::get('distributors/{id}/edit', [DistributorController::class, 'edit'])->middleware('user.admin');
    Route::put('distributors/{id}', [DistributorController::class, 'update'])->middleware('user.admin');
    Route::put('distributors/{id}/transfer-wallet', [DistributorController::class, 'transfer_wallet'])->middleware('user.admin');
    Route::put('distributors/{id}/pass-code', [DistributorController::class, 'pass_code'])->middleware('user.admin');
    Route::get('distributors/wallet-transfers', [DistributorController::class, 'wallet_transfers'])->middleware('user.admin');

    Route::get('my-tree', [MyTreeController::class, 'index'])->middleware('user.distributor');
    Route::get('my-tree/create', [MyTreeController::class, 'create'])->middleware('user.distributor');
    Route::post('my-tree', [MyTreeController::class, 'store'])->middleware('user.distributor');
    Route::get('my-tree/{id}', [MyTreeController::class, 'show'])->middleware('user.distributor');
    Route::get('users/{id}', [DashboardController::class, 'user_details'])->middleware('user.distributor');

    Route::get('request-withdrawal', [BonusController::class, 'request_withdrawal'])->middleware('user.distributor');

    Route::get('bonus-withdrawals', [BonusController::class, 'bonus_withdrawals'])->middleware('user.admin');

    Route::get('transactions', [DashboardController::class, 'transactions'])->middleware('user.distributor');
});
