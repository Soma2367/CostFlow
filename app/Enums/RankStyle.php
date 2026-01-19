<?php

namespace App\Enums;

enum RankStyle: int
{
    case FIRST = 0;
    case SECOND = 1;
    case THIRD = 2;

    public function borderColor(): string
    {
        return match($this) {
            self::FIRST => 'border-yellow-400',
            self::SECOND => 'border-gray-400',
            self::THIRD => 'border-orange-400',
        };
    }

    public function textClass(): string
    {
        return match($this) {
            self::FIRST => 'text-yellow-500',
            self::SECOND => 'text-gray-500',
            self::THIRD => 'text-orange-500',
        };
    }

    public static function fromIndex(int $index): self
    {
        return match($index) {
            0 => self::FIRST,
            1 => self::SECOND,
            2 => self::THIRD,
            default => self::THIRD,
        };
    }
}
