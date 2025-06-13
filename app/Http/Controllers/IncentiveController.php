<?php

namespace App\Http\Controllers;

use App\Models\Incentive;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IncentiveController extends Controller
{
    public function index(): View
    {
        return view('dashboard.incentive.index', [
            'incentives' => Incentive::orderBy('id', 'desc')->get()
        ]);
    }

    public function create(): View
    {
        return view('dashboard.incentive.create');
    }
}
