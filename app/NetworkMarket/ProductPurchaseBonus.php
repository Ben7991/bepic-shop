<?php

namespace App\NetworkMarket;

use App\Models\Distributor;
use App\Models\Transaction;
use App\Utils\Enum\TransactionType;

final class ProductPurchaseBonus
{
    public function awardSponsorBonus(Distributor $distributor, float $productPrice) {
       // 1. get the sponsor
       $referral = $distributor->referral;
       $sponsor = $referral->upline;
       $sponsorDistributorDetails = $sponsor->user->distributor;

       // 2. calculate the bonus amount
        $bonusRate = 20;
        $bonusAmount = $productPrice * $bonusRate;

        // 3. give sponsor the bonus and store the transaction
        $sponsorDistributorDetails->bonus += $bonusAmount;
        Transaction::create([
            'distributor_id' => $sponsorDistributorDetails->id,
            'transaction_type' => TransactionType::BONUS->name,
            'amount' => $bonusAmount
        ]);
        $sponsorDistributorDetails->save();
    }
}