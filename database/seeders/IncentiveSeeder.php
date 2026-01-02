<?php

namespace Database\Seeders;

use App\Models\Incentive;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncentiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Incentive::create([
            'point' => 200,
            'distributor_award' => 'Washing machine',
            'sponsor_award' => 'Airflyer',
        ]);

        Incentive::create([
            'point' => 700,
            'distributor_award' => 'Freezer',
            'sponsor_award' => 'TV',
        ]);

        Incentive::create([
            'point' => 3500,
            'distributor_award' => 'Dubai',
            'sponsor_award' => 'Dubai',
        ]);

        Incentive::create([
            'point' => 10000,
            'distributor_award' => '1st Car',
            'sponsor_award' => 'Motor',
        ]);

        Incentive::create([
            'point' => 25000,
            'distributor_award' => '4x4',
            'sponsor_award' => 'Small car',
        ]);
    }
}
