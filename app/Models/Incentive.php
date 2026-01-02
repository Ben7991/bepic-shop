<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incentive extends Model
{
    protected $fillable = [
        'point',
        'distributor_award',
        'sponsor_award',
    ];
}
