<?php

namespace App\Enums;

enum SubscriptionStatus: string
{
    case ACTIVE = 'active';
    case PAUSED = 'paused';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => '有効',
            self::PAUSED=> '一時停止',
            self::CANCELLED => '解約',
        };
    }

    public function statusColor(): string
    {
        return match($this) {
            self::ACTIVE => 'bg-green-100 text-green-700',
            self::PAUSED => 'bg-gray-100 text-gray-600',
            self::CANCELLED=> 'bg-gray-100 text-gray-600',
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
