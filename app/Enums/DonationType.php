<?php

namespace App\Enums;

enum DonationType: string
{
    case CASH = 'cash';
    case IN_KIND = 'in_kind';

    /**
     * Get the label for the donation type.
     */
    public function label(): string
    {
        return match ($this) {
            self::CASH => 'Cash',
            self::IN_KIND => 'In-kind',
        };
    }
}
