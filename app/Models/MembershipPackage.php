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

    public static function getMembershipPackageById(int $id): MembershipPackage
    {
        $membershipPackage = MembershipPackage::find($id);

        if ($membershipPackage === null) {
            throw new \Exception('Membership package not recognized');
        }

        return $membershipPackage;
    }
}
