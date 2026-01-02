<?php

namespace Database\Seeders;

use App\Models\Distributor;
use App\Models\Upline;
use App\Models\User;
use App\Utils\Enum\Leg;
use App\Utils\Enum\Role;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => User::getNextId(Role::ADMIN),
            'name' => 'Admin',
            'username' => 'admin1234',
            'password' => 'admin1234',
            'role' => Role::ADMIN->name,
        ]);

        $masterUser = User::create([
            'id' => User::getNextId(Role::DISTRIBUTOR),
            'name' => 'Root User',
            'username' => Hash::make('master-12'),
            'password' => Hash::make('master-12$'),
            'role' => Role::DISTRIBUTOR->name
        ]);

        $upline = Upline::create([
            'user_id' => $masterUser->id
        ]);

        $companyUser = User::create([
            'id' => User::getNextId(Role::DISTRIBUTOR),
            'name' => 'Company User',
            'username' => Hash::make('company-user-12'),
            'password' => Hash::make('company-user-12$'),
            'role' => Role::DISTRIBUTOR->name
        ]);

        Distributor::create([
            'leg' => Leg::LEFT->name,
            'phone_number' => '0000000000',
            'country' => 'Ghana',
            'user_id' => $companyUser->id,
            'upline_id' => $upline->id,
            'next_maintenance' => Carbon::now(),
        ]);
    }
}
