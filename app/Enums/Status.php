<?php

declare(strict_types=1);

namespace App\Enums;

enum Status: string
{
    case Active = 'active';
    case Inactive = 'inactive';

    /**
     * Get all enum values with their labels.
     *
     * @return array<string, string>
     */
    public static function getLabels(): array
    {
        return [
            self::Active->value => self::Active->label(),
            self::Inactive->value => self::Inactive->label(),
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
            self::Active => 'Trạng thái hoạt động, cho phép sử dụng và hiển thị.',
            self::Inactive => 'Trạng thái không hoạt động, tạm dừng sử dụng hoặc ẩn.',
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
            self::Active => 'Hoạt động',
            self::Inactive => 'Không hoạt động',
        };
    }
}
