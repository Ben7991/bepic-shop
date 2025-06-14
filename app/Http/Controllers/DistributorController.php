<?php

namespace App\Http\Controllers;

use App\Http\Dto\DistributorDtoBuilder;
use App\Http\Requests\Dashboard\DistributorRequest;
use App\Models\Distributor;
use App\Models\MembershipPackage;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use App\NetworkMarket\CashBonus;
use App\NetworkMarket\CyclePoint;
use App\Utils\Enum\Role;
use App\Utils\Enum\TransactionType;
use App\Utils\Enum\UserStatus;
use App\Utils\TextGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DistributorController extends Controller
{
    public function index(): View
    {
        $users = User::where('status', UserStatus::ACTIVE->name)
            ->where('role', Role::DISTRIBUTOR->name)
            ->orderBy('id', 'desc')
            ->get();

        return view('dashboard.distributor.index', [
            'users' => $users
        ]);
    }

    public function create(): View
    {
        return view('dashboard.distributor.create', [
            'packages' => MembershipPackage::all()
        ]);
    }

    public function store(DistributorRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $builder = (new DistributorDtoBuilder())
                ->setName($validated['name'])
                ->setUsername($validated['username'])
                ->setUplineId($validated['upline_id'])
                ->setSelectedLeg($validated['leg'])
                ->setMembershipPackageId($validated['package'])
                ->setPhone($validated['phone'])
                ->setCountry($validated['country']);

            $password = TextGenerator::generate();
            $membershipPackage = MembershipPackage::getMembershipPackageById((int)$validated['package']);
            $uplineUser = User::getUserById($validated['upline_id']);
            $upline = $uplineUser->getUpline();
            $uplineDistributorDetails = $uplineUser->distributor;

            if ($uplineDistributorDetails->wallet < $membershipPackage->price) {
                throw new \Exception("Insufficient balance in upline's wallet");
            }

            $distributorUserDetails = User::createViaDistributorData($builder->name, $builder->username, $password);
            $distributor = Distributor::createViaDtoBuilder($builder, $distributorUserDetails->id, $upline->id);

            $uplineDistributorDetails->wallet -= $membershipPackage->price;
            $uplineDistributorDetails->save();

            Transaction::create([
                'distributor_id' => $distributor->id,
                'transaction_type' => TransactionType::REGISTRATION->name,
                'amount' => $membershipPackage->price
            ]);

            $upline->save();

            Referral::create([
                'upline_id' => $upline->id,
                'distributor_id' => $distributor->id
            ]);

            $cashBonus = new CashBonus($upline, $distributor, $membershipPackage->price);
            $cashBonus->awardCashBonus();

            $cyclePoint = new CyclePoint($upline, $builder->leg, $membershipPackage->point);
            $cyclePoint->cycle();

            return redirect('/dashboard/distributors')->with([
                'message' => "Distributor added successfully with password => $password",
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function edit(string $id): View | RedirectResponse
    {
        try {
            $user = User::findOrFail($id);

            return view('dashboard.distributor.edit', [
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Distributor not found',
                'variant' => 'error'
            ]);
        }
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            "name" => "bail|required|regex:/^[a-zA-Z ]*$/",
            "country" => "required",
            "phone" => "required",
        ]);

        try {
            $user = User::findOrFail($id);
            $user->name = $this->sanitize($validated['name']);
            $user->save();

            $distributor = $user->distributor;
            $distributor->country = $this->sanitize($validated['country']);
            $distributor->phone_number = $this->sanitize($validated['phone']);
            $distributor->save();

            return redirect()->back()->with([
                'message' => 'Distributor updated successfully',
                'variant' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Distributor not found',
                'variant' => 'error'
            ]);
        }
    }

    public function transfer_wallet(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric'
        ]);

        try {
            $amount = (float)$this->sanitize($validated['amount']);

            $user = User::findOrFail($id);
            $distributor = $user->distributor;
            $distributor->wallet += $amount;
            $distributor->save();

            Transaction::create([
                'distributor_id' => $distributor->id,
                'transaction_type' => TransactionType::DEPOSIT->name,
                'amount' => $amount
            ]);

            return redirect()->back()->with([
                'message' => 'Transferred wallet successfully',
                'variant' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Something went wrong',
                'variant' => 'error'
            ]);
        }
    }

    public function pass_code(Request $request, string $id): RedirectResponse
    {
        try {
            $password = TextGenerator::generate();

            $user = User::findOrFail($id);
            $user->password = $password;
            $user->save();

            return redirect()->back()->with([
                'message' => "Distributor password changed to $password successfully",
                'pass' => 'yes'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Distributor not found',
                'pass' => 'yes'
            ]);
        }
    }

    public function wallet_transfers(): View
    {
        return view('dashboard.distributor.wallet-transfer', [
            'transactions' => Transaction::where('transaction_type', TransactionType::DEPOSIT->name)->get()
        ]);
    }
}
