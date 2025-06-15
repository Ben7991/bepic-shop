<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BonusWithdrawal;
use App\Models\Distributor;
use App\Models\Order;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use App\Utils\Enum\RecordStatus;
use App\Utils\Enum\Role;
use App\Utils\Enum\TransactionType;
use App\Utils\Enum\UserStatus;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private function getTotalOrders(int $distributorId)
    {
        $orderSummary = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('distributors', 'distributors.id', '=', 'orders.distributor_id')
            ->join('users', 'users.id', '=', 'distributors.user_id')
            ->select(DB::raw('orders.distributor_id, distributors.user_id as id, users.name, users.username, SUM(orders.quantity * products.price) as total_purchase'))
            ->where('distributor_id', $distributorId)
            ->groupBy('orders.distributor_id', 'distributors.user_id', 'users.name', 'users.username')
            ->orderBy('total_purchase', 'desc')
            ->take(10)
            ->first();

        return $orderSummary->total_purchase ?? 0;
    }

    private function getDistributorDashboardData(): array
    {
        $distributor = Auth::user()->distributor;
        $transactions = Transaction::where('distributor_id', $distributor->id)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();
        $withdrawals = BonusWithdrawal::where('distributor_id', $distributor->id)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $upline = Auth::user()->upline;
        $usersAdded = 0;

        if ($upline !== null) {
            $usersAdded = Referral::where('upline_id', $upline->id)->count();
        }

        $currentDate = Carbon::now();
        $nextMaintenance = Carbon::parse($distributor->next_maintenance);
        $remainingDays = (int)$currentDate->diffInDays($nextMaintenance);

        return [
            'transactions' => $transactions,
            'withdrawals' => $withdrawals,
            'users_added' => $usersAdded,
            'remainingDays' => $remainingDays,
            'totalOrders' => $this->getTotalOrders($distributor->id)
        ];
    }

    private function getAdminDashboardData(): array
    {
        $bonusWithdrawalCount = BonusWithdrawal::count();
        $walletTransferCount = Transaction::where('transaction_type', TransactionType::DEPOSIT->name)
            ->count();
        $distributorCount = User::where('role', Role::DISTRIBUTOR->name)
            ->where('status', UserStatus::ACTIVE->name)
            ->count();

        $recentDistributors = User::where('role', Role::DISTRIBUTOR->name)
            ->where('status', UserStatus::ACTIVE->name)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $recentWithdrawals = BonusWithdrawal::orderBy('id', 'desc')
            ->take(5)
            ->get();

        return [
            'distributorCount' => $distributorCount,
            'walletTransferCount' => $walletTransferCount,
            'bonusWithdrawalCount' => $bonusWithdrawalCount,
            'recentDistributors' => $recentDistributors,
            'recentWithdrawals' => $recentWithdrawals
        ];
    }

    public function index(): View
    {
        if (Auth::user()->role === Role::DISTRIBUTOR->name) {
            return view('dashboard.index', $this->getDistributorDashboardData());
        } else {
            return view('dashboard.index', $this->getAdminDashboardData());
        }
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
