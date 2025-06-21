<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\GroupPermission;
use Illuminate\Database\Seeder;

class GroupPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = config('group_permissions', []);
        foreach ($groups as $group) {
            $this->checkIssetBeforeCreate($group);
        }
    }
    private function checkIssetBeforeCreate($data): void
    {
        $groupPermission = GroupPermission::where('code', $data['code'])->first();
        if (empty($groupPermission)) {
            GroupPermission::create($data);
        } else {
            $groupPermission->update($data);
        }
    }
}
