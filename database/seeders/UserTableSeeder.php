<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Enums\Status;
use App\Enums\UserType;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tìm role Quản trị viên
        $adminRole = Role::where('name', 'Quản trị viên')->first();

        if (!$adminRole) {
            $this->command->error('Không tìm thấy role "Quản trị viên". Vui lòng chạy RoleTableSeeder trước.');
            return;
        }

        // Tạo user admin với role Quản trị viên
        $adminUser = User::firstOrCreate(
            ['sso_id' => 'ADMIN001'],
            [
                'sso_id' => 'ADMIN001',
                'full_name' => 'Quản trị viên hệ thống',
                'code' => 'ADMIN001',
                'role_id' => $adminRole->id,
                'status' => Status::Active,
                'type' => UserType::Admin,
                'user_data' => [
                    'email' => 'admin@vnua.edu.vn',
                    'department' => 'Phòng Công nghệ thông tin',
                ],
            ]
        );

        $this->command->info("Đã tạo user admin: {$adminUser->full_name} với role {$adminRole->name}");
    }
}
