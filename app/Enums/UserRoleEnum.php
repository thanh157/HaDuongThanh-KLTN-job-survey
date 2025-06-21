<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case SuperAdmin = 'super_admin';
    case Officer = 'officer';
    case Student = 'student';
    case Normal = 'normal';

    public static function getDescription()
    {
        return [
            self::SuperAdmin->value => 'Quản trị viên',
            self::Officer->value => 'Giảng viên - Cán bộ khoa',
            self::Student->value => 'Học sinh',
            self::Normal->value => 'Cơ bản',
        ];
    }

    public function getLabel(): string
    {
        return self::getDescription()[$this->value];
    }
}