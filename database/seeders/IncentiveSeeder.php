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
            'point' => 150,
            'award' => 'Washing machine',
        ]);

        Incentive::create([
            'point' => 500,
            'award' => 'Travel for 2',
        ]);

        Incentive::create([
            'point' => 2000,
            'award' => 'Travel / Ghc30,000',
        ]);

        Incentive::create([
            'point' => 8500,
            'award' => 'Car / Ghcc120,000',
        ]);
    }
}
