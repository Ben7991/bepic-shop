<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DistributorController extends Controller
{
    public function index(): View
    {
        return view('dashboard.distributor.index');
    }
}
