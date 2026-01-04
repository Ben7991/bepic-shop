<?php

namespace App\Http\Controllers;

use App\Http\Dto\DistributorDtoBuilder;
use App\Http\Requests\Dashboard\DistributorRequest;
use App\Models\Distributor;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\Upline;
use App\Models\User;
use App\NetworkMarket\CyclePoint;
use App\Utils\Enum\Leg;
use App\Utils\Enum\TransactionType;
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
        return view('dashboard.my-tree.create');
    }

    public function store(DistributorRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($validated['username'] === $validated['password'] || $validated['name'] === $validated['password']) {
            return redirect()->back()->with([
                'message' => "Password can't be the same as your username or name"
            ]);
        }

        try {
            $builder = (new DistributorDtoBuilder())
                ->setName($validated['name'])
                ->setUsername($validated['username'])
                ->setUplineId($validated['upline_id'])
                ->setSelectedLeg($validated['leg'])
                ->setPassword($validated['password'])
                ->setPhone($validated['phone'])
                ->setCountry($validated['country']);

            $loggedIdUser = Auth::user();

            $uplineUser = User::getUserById($builder->uplineId);
            $upline = $uplineUser->getUpline();

            $registrationPriceOrPoint = 70;

            if ($this->checkIfSpaceIsNotOccupied($upline, $builder->leg)) {
                throw new \Exception('Leg already occupied');
            }

            $uplineDistributorDetails = $uplineUser->distributor;

            $referral = $loggedIdUser->getUpline();

            if ($loggedIdUser->id !== $uplineUser->id) {
                $uplineDistributorDetails = $loggedIdUser->distributor;
            }

            if ($uplineDistributorDetails->wallet < $registrationPriceOrPoint) {
                throw new \Exception("Insufficient balance in upline's wallet");
            }

            $distributorUserDetails = User::createViaDistributorData($builder);
            $distributor = Distributor::createViaDtoBuilder($builder, $distributorUserDetails->id, $upline->id);

            $uplineDistributorDetails->wallet -= $registrationPriceOrPoint;
            $uplineDistributorDetails->save();

            Transaction::create([
                'distributor_id' => $distributor->id,
                'transaction_type' => TransactionType::REGISTRATION->name,
                'amount' => $registrationPriceOrPoint
            ]);

            Referral::create([
                'upline_id' => $referral->id,
                'distributor_id' => $distributor->id
            ]);

            $cyclePoint = new CyclePoint($upline, $builder->leg, $registrationPriceOrPoint);
            $cyclePoint->cycle();

            return redirect('/dashboard/my-tree')->with([
                'message' => "Distributor added successfully",
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function checkIfSpaceIsNotOccupied(Upline $upline, Leg $leg): bool
    {
        $distributors = $upline->distributors;

        if (count($distributors) === 2) {
            return true;
        }

        foreach ($distributors as $distributor) {
            if ($distributor->leg === $leg->name) {
                return true;
            }
        }

        return false;
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
