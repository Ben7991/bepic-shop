<?php

namespace Database\Seeders;

use App\Models\MembershipPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembershipPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MembershipPackage::create([
            'point' => 1,
            'product_quantity' => 1,
            'price' => 150,
        ]);

        MembershipPackage::create([
            'point' => 7,
            'product_quantity' => 7,
            'price' => 1050,
        ]);

        MembershipPackage::create([
            'point' => 15,
            'product_quantity' => 15,
            'price' => 2250,
        ]);

        MembershipPackage::create([
            'point' => 30,
            'product_quantity' => 30,
            'price' => 4500,
        ]);
    }
}
