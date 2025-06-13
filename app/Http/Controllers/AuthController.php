<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Home\SignInRequest;
use App\Utils\Enum\UserStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
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

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
