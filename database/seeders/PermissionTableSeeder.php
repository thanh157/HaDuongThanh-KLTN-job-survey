<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = config('permissions', []);
        foreach ($permissions as $permission) {
            $this->checkIssetBeforeCreate($permission);
        }
    }
    public function checkIssetBeforeCreate($data): void
    {
        $permission = Permission::where('code', $data['code'])->first();
        if (empty($permission)) {
            Permission::create($data);
        } else {
            $permission->update($data);
        }
    }
}
