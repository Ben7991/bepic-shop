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
use App\Utils\Enum\TransactionType;
use App\Utils\TextGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MyTreeController extends Controller
{
    public function index(): View
    {
        $leftLeg = $rightLeg = $totalMatchingPoint = 0;
        $upline = Auth::user()->upline;
        $distributors = [];

        if ($upline) {
            $leftLeg = $upline->left_leg;
            $rightLeg = $upline->right_leg;
            $totalMatchingPoint = min($leftLeg, $rightLeg);
            $distributors = $upline->distributors;
        }

        return view('dashboard.my-tree.index', [
            'leftLeg' => $leftLeg,
            'rightLeg' => $rightLeg,
            'totalMatchingPoint' => $totalMatchingPoint,
            'distributors' => $distributors
        ]);
    }

    public function create(): View
    {
        return view('dashboard.my-tree.create', [
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

            $loggedIdUser = Auth::user();

            $password = TextGenerator::generate();
            $membershipPackage = MembershipPackage::getMembershipPackageById((int)$validated['package']);
            $uplineUser = User::getUserById($builder->uplineId);
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

            $referral = $loggedIdUser->getUpline();

            Referral::create([
                'upline_id' => $referral->id,
                'distributor_id' => $distributor->id
            ]);

            $cashBonus = new CashBonus($referral, $distributor, $membershipPackage->price);
            $cashBonus->awardCashBonus();

            $cyclePoint = new CyclePoint($upline, $builder->leg, $membershipPackage->point);
            $cyclePoint->cycle();

            return redirect('/dashboard/my-tree')->with([
                'message' => "Distributor added successfully with password => $password",
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function show(string $id): View | RedirectResponse
    {
        try {
            $user = User::findOrFail($id);
            $upline = $user->upline;
            $distributors = [];
            $leftLeg = $rightLeg = 0;
            $totalMatching = 0;

            if ($upline !== null) {
                $distributors = $upline->distributors;
                $leftLeg = $upline->left_leg;
                $rightLeg = $upline->right_leg;
                $totalMatching = min($upline->left_leg, $upline->right_leg);
            }

            return view("dashboard.my-tree.show", [
                "upline" => $upline,
                "distributors" => $distributors,
                "left_leg" => $leftLeg,
                "right_leg" => $rightLeg,
                "user" => $user,
                "totalMatching" => $totalMatching
            ]);
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
}
