<?php

namespace App\NetworkMarket;

use App\Models\Award;
use App\Models\Distributor;
use App\Models\Incentive;
use App\Models\Upline;
use Illuminate\Database\Eloquent\Collection;

class AwardIncentive
{
    private Collection $incentives;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->setIncentives();
    }

    private function setIncentives(): void
    {
        $this->incentives = Incentive::orderBy('point', 'desc')->get();
    }

    public function awardIncentive(Upline $upline, Distributor $distributor): void
    {
        $minimumPoint = min($upline->left_leg, $upline->right_leg);

        if ($minimumPoint === 0 || $minimumPoint === null)
            return;


        $attainedIncentive = $this->getIncentiveWon($minimumPoint);

        if ($attainedIncentive === null)
            return;

        $wonIncentiveAlreadyAwarded = $this->checkIfAttainedIncentiveAlreadyAwarded($attainedIncentive, $distributor);

        if ($wonIncentiveAlreadyAwarded)
            return;

        // award distributor
        Award::create([
            'distributor_id' => $distributor->id,
            'award' => $attainedIncentive->distributor_award,
            'from' => 'Point accumulation'
        ]);
        
        // award sponsor
        $sponsor = $distributor->referral->upline;
        $sponsorDistributor = $sponsor->user->distributor;
        Award::create([
            'distributor_id' => $sponsorDistributor->id,
            'award' => $attainedIncentive->sponsor_award,
            'from' => $distributor->user->name . " (" . $distributor->user->id . ")",
        ]);
    }

    private function getIncentiveWon($minimumPoint): Incentive | null
    {
        foreach ($this->incentives as $incentive) {
            if ($minimumPoint >= $incentive->point) {
                return $incentive;
            }
        }

        return null;
    }

    private function checkIfAttainedIncentiveAlreadyAwarded(Incentive $attainedIncentive, Distributor $distributor): bool
    {
        $existing = Award::where('award', $attainedIncentive->distributor_award)
            ->where('distributor_id', $distributor->id)
            ->first();

        if ($existing !== null) {
            return true;
        }

        return false;
    }
}
