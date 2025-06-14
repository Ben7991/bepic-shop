<?php

namespace App\Http\Controllers;

use App\Models\MembershipPackage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MyTreeController extends Controller
{
    public function index(): View
    {
        return view('dashboard.my-tree.index');
    }

    public function create(): View
    {
        return view('dashboard.my-tree.create', [
            'packages' => MembershipPackage::all()
        ]);
    }
}
