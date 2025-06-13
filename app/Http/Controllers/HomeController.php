<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Home\SignInRequest;
use App\Utils\Enum\UserStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home.index');
    }

    public function login(): View
    {
        return view('home.login');
    }

    public function sign_in(SignInRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['status'] = UserStatus::ACTIVE->name;

        try {
            if (Auth::attempt($validated)) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }

            return redirect()->back()->with([
                'message' => 'Invalid login credentials'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Something went wrong'
            ]);
        }
    }
}
