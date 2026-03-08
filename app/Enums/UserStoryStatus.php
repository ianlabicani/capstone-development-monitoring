<?php

namespace App\Enums;

enum UserStoryStatus: string
{
    case Draft = 'draft';
    case Approved = 'approved';
    case Outdated = 'outdated';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Approved => 'Approved',
            self::Outdated => 'Outdated',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => 'slate',
            self::Approved => 'emerald',
            self::Outdated => 'amber',
        };
    }
}
