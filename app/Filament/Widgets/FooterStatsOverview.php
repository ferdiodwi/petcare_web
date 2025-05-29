<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FooterStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // Stat::make('Produk Stok Rendah', Product::where('stock', '<', 5)->count())
            //     ->icon('heroicon-o-exclamation-triangle')
            //     ->description('Perlu restock segera')
            //     ->color('danger'),

            // Stat::make('Pesanan Pending', Order::where('status', 'pending')->count())
            //     ->icon('heroicon-o-clock')
            //     ->description('Menunggu konfirmasi')
            //     ->color('warning'),

            // Stat::make(
            //     'Produk Terlaris',
            //     Product::withCount('orderItems')
            //         ->orderBy('order_items_count', 'desc')
            //         ->first()?->name ?? '-'
            // )
            //     ->icon('heroicon-o-star')
            //     ->description('Produk paling banyak dibeli')
            //     ->color('primary'),
        ];
    }
}
