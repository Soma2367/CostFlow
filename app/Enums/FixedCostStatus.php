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

     public function statusColor(): string
    {
        return match($this) {
            self::ACTIVE => 'bg-green-100 text-green-700',
            self::INACTIVE => 'bg-gray-100 text-gray-600',
        };
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label()
        ], self::cases());
    }
}
