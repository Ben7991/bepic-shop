<?php

namespace App\NetworkMarket;

use App\Models\Distributor;
use App\Models\Transaction;
use App\Models\Upline;
use App\Utils\Enum\TransactionType;

final class CashBonus
{
    /**
     * Distributor and upline bonus rate
     * This rate is used to multiple the selected membership package price
     * to determine the cash bonus
     */
    private static float $bonusRate = 0.134;

    /**
     * Create a new class instance.
     */
    public function __construct(
        private Upline $upline,
        private Distributor $distributor,
        private float $amount,
    ) {}

    public function awardCashBonus(): void
    {
        $bonusAmount = self::$bonusRate * $this->amount;
        $this->awardUplineCashBonus($bonusAmount);
        $this->awardDistributorCashBonus($bonusAmount);
    }

    private function awardUplineCashBonus(float $bonusAmount): void
    {
        $user = $this->upline->user;
        $distributor = $user->distributor;
        $distributor->bonus += $bonusAmount;
        $distributor->save();

        $this->recordTransaction($distributor, $bonusAmount);
    }

    private function recordTransaction(Distributor $distributor, float $bonusAmount): void
    {
        Transaction::create([
            'distributor_id' => $distributor->id,
            'transaction_type' => TransactionType::BONUS->name,
            'amount' => $bonusAmount
        ]);
    }

    private function awardDistributorCashBonus(float $bonusAmount): void
    {
        $this->distributor->bonus += $bonusAmount;
        $this->distributor->save();

        $this->recordTransaction($this->distributor, $bonusAmount);
    }
}
