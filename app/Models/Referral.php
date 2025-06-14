<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'upline_id',
        'distributor_id'
    ];

    public function upline()
    {
        return $this->belongsTo(Upline::class);
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }
}
