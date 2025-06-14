<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class BonusController extends Controller
{
    public function request_withdrawal(): View
    {
        return view('dashboard.bonus.request-withdrawal');
    }

    public function bonus_withdrawals(): View
    {
        return view('dashboard.bonus.bonus-withdrawals');
    }
}
