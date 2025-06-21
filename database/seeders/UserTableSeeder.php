<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'user_name' => 'system_admin',
            'first_name' => 'Admin',
            'last_name' => 'System',
            'email' => 'stdse@vnua.edu.vn',
            'password' => '123456aA@',
            'role' => 'super_admin',
            'status' => 'active',
            'code' => 'ADMIN001',
            'email_verified_at' => now(),
        ]);
    }
}
