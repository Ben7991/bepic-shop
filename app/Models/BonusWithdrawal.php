<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonusWithdrawal extends Model
{
    public $fillable = [
        "amount",
        "distributor_id",
        "deduction",
        "status"
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }
}
