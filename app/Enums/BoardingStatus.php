<?php

namespace App\Enums;

enum BoardingStatus: string
{
    case PENDING = 'pending';
    case confirm = 'confirm';
    case CANCELLED = 'cancelled';

    // Opsional: Anda bisa menambahkan method untuk mendapatkan label yang lebih ramah pengguna
    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::confirm => 'Aktif',
            self::CANCELLED => 'Dibatalkan',
        };
    }
}
