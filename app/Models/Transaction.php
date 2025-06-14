<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $fillable = [
        'distributor_id',
        'transaction_type',
        'amount'
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }
}
