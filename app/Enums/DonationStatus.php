<?php

namespace App\Enums;

enum DonationStatus: string
{
    case SUBMITTED = 'submitted';
    case STORED = 'stored';
    case ALLOCATED = 'allocated';
    case DISTRIBUTED = 'distributed';

    /**
     * Get the label for the donation status.
     */
    public function label(): string
    {
        return match ($this) {
            self::SUBMITTED => 'Submitted',
            self::STORED => 'Stored',
            self::ALLOCATED => 'Allocated',
            self::DISTRIBUTED => 'Distributed',
        };
    }

    /**
     * Get the color for the badge representation.
     */
    public function color(): string
    {
        return match ($this) {
            self::SUBMITTED => 'primary',
            self::STORED => 'info',
            self::ALLOCATED => 'warning',
            self::DISTRIBUTED => 'success',
        };
    }
}
