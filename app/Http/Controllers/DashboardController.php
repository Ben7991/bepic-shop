<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use App\Utils\Enum\RecordStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        return view('dashboard.order-history', [
            'orders' => Order::orderBy('id', 'desc')->get(),
            'pending' => Order::where('status', RecordStatus::PENDING->name)->count(),
        ]);
    }

    public function approve_order(int $id): RedirectResponse
    {
        try {
            $order = Order::find($id);
            $order->status = RecordStatus::APPROVED->name;
            $order->save();

            return redirect()->back()->with('message', 'Order approved successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function purchase_history(): View
    {
        $user = Auth::user();
        $distributor = $user->distributor;
        $pending = Order::where('status', RecordStatus::PENDING->name)
            ->where('distributor_id', $distributor->id)
            ->count();

        return view('dashboard.purchase-history', [
            'orders' => Order::where('distributor_id', $distributor->id)->orderBy('id', 'desc')->get(),
            'pending' => $pending,
        ]);
    }

    public function top_sales_chart(): View
    {
        $result = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('distributors', 'distributors.id', '=', 'orders.distributor_id')
            ->join('users', 'users.id', '=', 'distributors.user_id')
            ->select(DB::raw('orders.distributor_id, distributors.user_id as id, users.name, SUM(orders.quantity * products.price) as total_purchase'))
            ->groupBy('orders.distributor_id', 'distributors.user_id', 'users.name', 'users.username')
            ->orderBy('total_purchase', 'desc')
            ->take(10)
            ->get();

        return view('dashboard.top-sales-chart', [
            'rows' => $result
        ]);
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

    public function user_details(int $id)
    {
        try {
            $distributor = Distributor::find($id);
            $user = $distributor->user;
            $leftLeg = $rightLeg = 0;

            if ($user->upline !== null) {
                $leftLeg = $user->upline->left_leg;
                $rightLeg = $user->upline->right_leg;
            }

            return response()->json([
                'data' => [
                    'name' => $user->name,
                    'id' => $user->id,
                    'left_leg' => $leftLeg,
                    'right_leg' => $rightLeg
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "User doesn't exist"
            ]);
        }
    }

    public function transactions(): View
    {
        $distributor = Auth::user()->distributor;

        return view('dashboard.transactions', [
            'transactions' => Transaction::where('distributor_id', $distributor->id)->orderBy('id', 'desc')->get()
        ]);
    }
}
