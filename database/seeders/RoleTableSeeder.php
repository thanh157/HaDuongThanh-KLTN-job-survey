<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo role Quản trị viên
        $adminRole = Role::firstOrCreate(
            ['name' => 'Quản trị viên'],
            [
                'name' => 'Quản trị viên',
                'description' => 'Vai trò quản trị viên có đầy đủ tất cả các quyền trong hệ thống',
                'faculty_id' => 1, // Không thuộc khoa cụ thể nào
            ]
        );

        // Lấy tất cả các quyền trong hệ thống
        $allPermissions = Permission::all();

        // Gán tất cả quyền cho role Quản trị viên
        if ($allPermissions->isNotEmpty()) {
            $adminRole->permissions()->sync($allPermissions->pluck('id')->toArray());
            
            $this->command->info("Đã tạo role 'Quản trị viên' với {$allPermissions->count()} quyền");
        } else {
            $this->command->warn("Không tìm thấy quyền nào trong hệ thống. Vui lòng chạy PermissionTableSeeder trước.");
        }

       
        // cập nhật role cho các user hiện tại trên hệ thống
        User::whereNull('role_id')->update(['role_id' => $adminRole->id]);
    }
}
