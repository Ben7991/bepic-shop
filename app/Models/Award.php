<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    public $fillable = [
        'distributor_id',
        'award',
        'from',
        'status'
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    public function incentive()
    {
        return $this->belongsTo(Incentive::class);
    }
}
