<?php

namespace App\NetworkMarket;

use App\Models\Distributor;
use App\Models\Upline;
use App\Utils\Enum\Leg;
use Carbon\Carbon;

class CyclePoint
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private Upline $upline,
        private Leg $leg,
        private int $point
    ) {}

    public function cycle()
    {
        $upline = $this->upline;
        $user = $upline->user;
        $distributor = $user->distributor;
        $leg = $this->leg;

        while (true) {
            if ($this->isAccountMaintained($distributor)) {
                $this->incrementPoint($upline, $leg);
            }

            $this->incrementLegCount($upline, $leg);

            $leg = $distributor->leg === "LEFT" ? Leg::LEFT : Leg::RIGHT;

            $upline = $distributor->upline;
            $user = $upline->user;
            $distributor = $user->distributor;

            if ($distributor === null) {
                break;
            }
        }
    }

    private function isAccountMaintained(Distributor $distributor)
    {
        $currentDate = new Carbon();
        $expiringDate = Carbon::parse($distributor->next_maintenance);
        return $expiringDate->greaterThanOrEqualTo($currentDate);
    }


    private function incrementPoint(Upline $upline, Leg $leg)
    {
        if ($leg === Leg::LEFT) {
            $upline->left_leg += $this->point;
        } else {
            $upline->right_leg += $this->point;
        }

        $upline->save();
    }

    private function incrementLegCount(Upline $upline, Leg $leg)
    {
        if ($leg === Leg::LEFT) {
            $upline->left_leg_count += $this->point;
        } else {
            $upline->right_leg_count += $this->point;
        }

        $upline->save();
    }
}
