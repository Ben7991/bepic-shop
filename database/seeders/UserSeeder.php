<?php

namespace Database\Seeders;

use App\Models\User;
use App\Utils\Enum\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
    }
}
