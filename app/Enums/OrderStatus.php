<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROSES = 'proses';
    case SHIPPED = 'shipped';
    case SELESAI = 'selesai';
    case CANCELED = 'canceled';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::PROSES => 'Proses',
            self::SHIPPED => 'Dikirim',
            self::SELESAI => 'Selesai',
            self::CANCELED => 'Dibatalkan',
        };
    }
}
