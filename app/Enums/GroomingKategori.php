<?php

namespace App\Enums;

enum GroomingKategori: string
{
    case BASIC = 'basic';
    case PREMIUM = 'premium';
    case FULL_TREATMENT = 'full_treatment';

    public function getLabel(): string
    {
        return match ($this) {
            self::BASIC => 'Basic',
            self::PREMIUM => 'Premium',
            self::FULL_TREATMENT => 'Full Treatment',
        };
    }
}
