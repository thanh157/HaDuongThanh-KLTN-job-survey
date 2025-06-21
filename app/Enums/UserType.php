<?php

declare(strict_types=1);

namespace App\Enums;

enum UserType: string
{
    case Admin = 'admin';
    case Teacher = 'teacher';
    case Officer = 'officer';
    case Student = 'student';

    /**
     * Get all enum values with their labels.
     *
     * @return array<string, string>
     */
    public static function getLabels(): array
    {
        return [
            self::Admin->value => self::Admin->label(),
            self::Teacher->value => self::Teacher->label(),
            self::Officer->value => self::Officer->label(),
            self::Student->value => self::Student->label(),
        ];
    }

    /**
     * Get the description of the enum value.
     *
     * @return string
     */
    public function description(): string
    {
        return match($this) {
            self::Admin => 'Tài khoản quản trị viên, có quyền quản lý toàn bộ hệ thống.',
            self::Teacher => 'Tài khoản giảng viên, có quyền quản lý lớp học và sinh viên.',
            self::Officer => 'Tài khoản cán bộ khoa, có quyền quản lý sinh viên và thông tin khoa.',
            self::Student => 'Tài khoản sinh viên, có quyền xem thông tin cá nhân và lớp học.',
        };
    }

    /**
     * Get the label of the enum value.
     *
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::Admin => 'Quản trị viên',
            self::Teacher => 'Giảng viên',
            self::Officer => 'Cán bộ khoa',
            self::Student => 'Sinh viên',
        };
    }

    /**
     * Get the badge color for the user type.
     *
     * @return string
     */
    public function badgeColor(): string
    {
        return match($this) {
            self::Admin => 'bg-primary',
            self::Teacher => 'bg-info',
            self::Officer => 'bg-secondary',
            self::Student => 'bg-warning',
        };
    }
}
