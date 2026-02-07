<?php

namespace App\Enums;

enum Category: string
{
    case LIVING = 'living';
    case ENTERTAINMENT = 'entertainment';
    case PET = 'pet';
    case INSURANCE = 'insurance';
    case STUDY = 'study';

    public function label(): string
    {
        return match($this) {
            self::LIVING => '生活費',
            self::ENTERTAINMENT => 'エンタメ',
            self::PET => 'ペット',
            self::INSURANCE => '保険',
            self::STUDY => '勉強',
        };
    }

    public function CategoryColor(): string
    {
        return match($this) {
             self::LIVING => 'text-blue-700',
             self::ENTERTAINMENT => 'text-purple-700',
             self::PET => 'text-orange-700',
             self::INSURANCE => 'text-gray-700',
             self::STUDY => 'text-green-700',
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
