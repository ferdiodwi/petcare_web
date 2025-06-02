<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROSES = 'proses';
    case DIKIRIM = 'dikirim';
    case SELESAI = 'selesai';
    case DIBATALKAN = 'dibatalkan';

    // Opsional: Anda bisa menambahkan method untuk mendapatkan label yang lebih ramah pengguna
    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::PROSES => 'proses',
            self::DIKIRIM => 'dikirim',
            self::SELESAI => 'selesai',
            self::DIBATALKAN => 'dibatalkan'
        };
    }
}
