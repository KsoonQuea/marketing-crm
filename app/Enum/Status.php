<?php

namespace App\Enum;

enum Status:int
{
    case Active = 1;
    case Inactive = 0;

    public function getName(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
        };
    }
}
