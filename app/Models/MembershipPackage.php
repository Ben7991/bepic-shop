<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPackage extends Model
{
    public $fillable = [
        'point',
        'product_quantity',
        'price',
    ];
}
