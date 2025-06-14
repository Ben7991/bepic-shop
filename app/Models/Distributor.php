<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    public $fillable = [
        'leg',
        'phone_number',
        'country',
        'user_id',
        'upline_id',
        'next_maintenance',
        'membership_package_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function upline()
    {
        return $this->belongsTo(Upline::class);
    }

    public function membershipPackage()
    {
        return $this->belongsTo(MembershipPackage::class);
    }
}
