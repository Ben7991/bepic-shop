<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard.index');
    }

    public function membership_packages(): View
    {
        return view('dashboard.membership-packages');
    }

    public function incentives(): View
    {
        return view('dashboard.incentives');
    }

    public function products(): View
    {
        return view('dashboard.products');
    }

    public function order_history(): View
    {
        return view('dashboard.order-history');
    }

    public function top_sales_chart(): View
    {
        return view('dashboard.top-sales-chart');
    }

    public function wallet_transfer_history(): View
    {
        return view('dashboard.wallet-transfer-history');
    }

    public function bonus_withdrawals(): View
    {
        return view('dashboard.bonus-withdrawals');
    }

    public function distributors(): View
    {
        return view('dashboard.distributors');
    }

    public function account_settings(): View
    {
        return view('dashboard.account-settings');
    }
}
