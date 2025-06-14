<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upline extends Model
{
    public $fillable = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function distributors()
    {
        return $this->hasMany(Distributor::class);
    }
}
