<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipPackageController extends Controller
{
    public function index(): View
    {
        return view('dashboard.membership-package.index');
    }
}
