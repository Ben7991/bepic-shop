<?php

namespace App\Http\Controllers;

use App\Models\BonusWithdrawal;
use App\Models\Distributor;
use App\Utils\Enum\RecordStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BonusController extends Controller
{
    public function request_withdrawal(): View
    {
        $distributor = Auth::user()->distributor;
        $withdrawals = BonusWithdrawal::where('distributor_id', $distributor->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('dashboard.bonus.request-withdrawal', [
            'withdrawals' => $withdrawals
        ]);
    }

    public function submit_withdrawal_request(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric'
        ]);

        $amount = (float)$this->sanitize($validated['amount']);
        $deduction = $amount * 0.1;

        try {
            $distributor = Auth::user()->distributor;
            $bonus = (float) $distributor->bonus;

            if ($amount > $bonus) {
                return redirect()->back()->with([
                    'variant' => 'error',
                    'message' => 'Insufficient bonus to make this request'
                ]);
            }

            $pendingWithdrawals = BonusWithdrawal::where('distributor_id', $distributor->id)
                ->where('status', RecordStatus::PENDING->name)
                ->orderBy('id', 'desc')
                ->get();

            if (count($pendingWithdrawals) > 0) {
                throw new \Exception('You have a pending request, please wait for approval to request again');
            }

            BonusWithdrawal::create([
                "amount" => $amount,
                "distributor_id" => $distributor->id,
                "deduction" => $deduction,
                "status" => RecordStatus::PENDING->name
            ]);

            return redirect()->back()->with([
                'variant' => 'success',
                'message' => 'Request sent successfully'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => $e->getMessage(),
                'variant' => 'error',
            ]);
        }
    }

    public function bonus_withdrawals(): View
    {
        return view('dashboard.bonus.bonus-withdrawals', [
            'withdrawals' => BonusWithdrawal::orderBy('id', 'desc')->get()
        ]);
    }

    public function approve_bonus_withdrawal(int $id): RedirectResponse
    {
        try {
            $withdrawal = BonusWithdrawal::findOrFail($id);
            $withdrawal->status = RecordStatus::APPROVED->name;
            $withdrawal->save();

            $distributor = Distributor::find($withdrawal->distributor_id);
            $distributor->bonus -= $withdrawal->amount;
            $distributor->save();

            return redirect()->back()->with([
                'variant' => 'success',
                'message' => "Request approved successfully, don't forget to send the amount to the distributor"
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'variant' => 'error',
                'message' => 'Withdrawal record does not exist'
            ]);
        }
    }
}
