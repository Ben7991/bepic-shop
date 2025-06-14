<?php

namespace App\Models;

use App\Http\Dto\DistributorDtoBuilder;
use App\Utils\Enum\Leg;
use Carbon\Carbon;
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

    public static function createViaDtoBuilder(DistributorDtoBuilder $builder, string $userId, int $uplineId): self
    {
        return self::create([
            'leg' => $builder->leg,
            'phone_number' => $builder->phone,
            'country' => $builder->country,
            'user_id' => $userId,
            'upline_id' => $uplineId,
            'next_maintenance' => Carbon::now()->addDays(30),
            'membership_package_id' => $builder->membershipPackageId
        ]);
    }
}
