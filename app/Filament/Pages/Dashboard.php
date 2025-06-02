<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets; // Namespace untuk widget kustom kita

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            Widgets\AdminStatsOverview::class,
            // Widgets\NewCustomersChart::class,
            Widgets\LatestOrdersWidget::class,
            Widgets\LatestPendingBookingsWidget::class,
            Widgets\RevenueChart::class,
        ];
    }

    // Anda bisa mengatur kolom default untuk widget di dashboard
    public function getColumns(): int | string | array
    {
        return 2; // Misalnya, 2 kolom
    }

    // Anda bisa mengoverride judul dashboard jika perlu
    // public function getTitle(): string
    // {
    //     return 'Dasbor Utama';
    // }
}
