<?php

namespace App\NetworkMarket;

use App\Models\Transaction;
use App\Models\Upline;
use App\Utils\Enum\TransactionType;
use Carbon\Carbon;

final class CycleBonus
{
    public function awardBonus(Upline $upline): void
    {
        // ensure cycles for each day begins afresh
        $this->checkAndUpdateCycleInfo($upline);

        // check if qualified for bonus
        if (!$this->isQualifiedForBonus($upline)) {
            return;
        }

        // check for cut off to prevent giving award
        if ($this->reachedCutOff($upline)) {
            $minimumLeg = $this->minimumLeg($upline);
            $upline->cycles_awarded = $minimumLeg;
            $upline->save();
            return;
        }

        $this->updateBonus($upline);

        $minimumLeg = $this->minimumLeg($upline);
        $upline->cycles_awarded = $minimumLeg;
        $upline->save();
    }

    /**
     * ensure awarded cycle counts starts on a clean slate for each day
     * @return void
     */
    private function checkAndUpdateCycleInfo(Upline $upline): void
    {
        $lastDate = Carbon::parse($upline->cycles_awarded_date);
        $currentDate = Carbon::now();

        if ($lastDate->diffInDays($currentDate) >= 1) {
            $upline->cycles_awarded_date = $currentDate;
            $upline->cycles_awarded = 0;
        }
    }

    /**
     * award bonus only if the minimum leg between the left_leg or right_leg 
     * is greater than last_awarded_leg field on the upline object 
     */
    private function isQualifiedForBonus(Upline $upline): bool 
    {
        $minimumLeg = $this->minimumLeg($upline);
        return $upline->cycles_awarded < $minimumLeg;
    }

    private function minimumLeg(Upline $upline): int
    {
        $minimumLeg = min([$upline->left_leg, $upline->right_leg]);
        return $minimumLeg !== null ? $minimumLeg : 0;
    }

    /**
     * when cut off is reached, bonus is never award
     * and cut off only happens when the total cycles for the day reaches 25
     * or cycles
     * @return bool
     */
    private function reachedCutOff(Upline $upline): bool 
    {
        $cycles_awarded = $upline->cycles_awarded;

        if ($cycles_awarded === 0) {
            return false;
        }

        $result = $cycles_awarded / 70;

        if ($result === 25) {
            return true;
        }

        return $result / 5 === 0;
    }

    /**
     * update uplines' distributor data with the bonus amount award
     * and also it's transaction
     * @return void
     */
    private function updateBonus(Upline $upline) {
        $distributor = $upline->user->distributor;
        $bonusAmount = 25;
        Transaction::create([
            'distributor_id' => $distributor->id,
            'transaction_type' => TransactionType::BONUS->name,
            'amount' => $bonusAmount
        ]);
        $distributor->bonus = $bonusAmount;
        $distributor->save();
    }
}
