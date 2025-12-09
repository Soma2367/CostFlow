<?php

namespace App\Enums;

enum FixedCostStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => '有効',
            self::INACTIVE => '無効',
        };
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'lable' => $case->label()
        ], self::cases());
    }
}
