<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View {
        return view('home.index');
    }

    public function login(): View {
        return view('home.login');
    }
}
