<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard.index');
    }

    public function order_history(): View
    {
        return view('dashboard.order-history');
    }

    public function top_sales_chart(): View
    {
        return view('dashboard.top-sales-chart');
    }

    public function account_settings(): View
    {
        return view('dashboard.account-settings');
    }

    public function change_personal(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|regex:/[a-zA-Z0-9 ]*$/'
        ]);

        try {
            $user = Auth::user();
            $user->name = $validated['name'];
            $user->save();

            return redirect()->back()->with([
                'message' => 'Personal information saved successfully',
                'variant' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Something went wrong',
                'variant' => 'error'
            ]);
        }
    }

    public function change_password(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => 'required|regex:/^[a-zA-Z0-9]*$/',
            'new_password' => 'required|regex:/^[a-zA-Z0-9]*$/',
            'confirm_password' => 'required|same:new_password'
        ]);

        if ($validated['current_password'] === $validated['new_password']) {
            return redirect()->back()->with([
                'message' => 'Current password and new password should not be the same',
                'variant' => 'error'
            ]);
        }

        try {
            $user = Auth::user();

            if (!Hash::check($validated['current_password'], $user->password)) {
                throw new \Exception('Currend password does not match each other');
            }

            $user->password = $validated['confirm_password'];
            $user->save();

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with([
                'message' => 'Change password saved successfully',
                'variant' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => $e->getMessage(),
                'variant' => 'error'
            ]);
        }
    }
}
