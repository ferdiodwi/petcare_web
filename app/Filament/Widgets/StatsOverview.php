<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Produk', Product::count())
                ->icon('heroicon-o-shopping-bag')
                ->description('Jumlah produk petshop')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 8]),

            Stat::make('Pelanggan Aktif', Customer::count())
                ->icon('heroicon-o-users')
                ->description('Jumlah pelanggan terdaftar')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info')
                ->chart([3, 5, 2, 7, 4, 8, 3, 6]),

            Stat::make('Pesanan Bulan Ini', Order::whereMonth('created_at', now()->month)->count())
                ->icon('heroicon-o-shopping-cart')
                ->description('Pesanan dalam 30 hari terakhir')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning')
                ->chart([2, 4, 3, 6, 5, 7, 8, 9]),

            Stat::make('Total Pendapatan', 'Rp ' . number_format(Order::where('status', 'completed')->sum('total_amount'), 0, ',', '.'))
                ->icon('heroicon-o-currency-dollar')
                ->description('Pendapatan keseluruhan')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([5, 3, 7, 8, 4, 6, 9, 10]),

            Stat::make('Total Postingan', Post::count())
                ->icon('heroicon-o-document-text')
                ->description('Jumlah artikel blog')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->chart([1, 3, 2, 4, 3, 5, 4, 6]),

            Stat::make('Postingan Publik', Post::where('is_published', true)->count())
                ->icon('heroicon-o-check-circle')
                ->description('Artikel yang dipublikasikan')
                ->color('success')
                ->chart([1, 2, 1, 3, 2, 4, 3, 5]),
        ];
    }
}
