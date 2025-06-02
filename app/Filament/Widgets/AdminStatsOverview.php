<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\Grooming;
use App\Models\Boarding;
use App\Models\Post;
use App\Enums\GroomingStatus; // Pastikan Enum ini ada dan sesuai
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Hitung jumlah grooming pending dari GroomingResource
        $pendingGroomingsCount = Grooming::where('status', GroomingStatus::PENDING)->count();

        // Hitung jumlah order pending dari OrderResource
        $pendingOrdersCount = Order::where('status', 'pending')->count();

        // Hitung jumlah boarding pending dari BoardingResource
        $pendingBoardingsCount = Boarding::where('status', 'pending')->count();

        // Hitung jumlah artikel terbit dari PostResource
        $publishedPostsCount = Post::where('is_published', true)->count();

        // Hitung total produk dari ProductResource
        $totalProductsCount = Product::count();


        return [
            Stat::make('Total Pelanggan', Customer::count())
                ->description('Jumlah semua pelanggan terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make('Total Produk', $totalProductsCount) // Menggunakan hitungan dari ProductResource
                ->description('Jumlah semua produk tersedia')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('primary'),
            Stat::make('Pesanan Pending', $pendingOrdersCount) // Menggunakan hitungan dari OrderResource
                ->description('Pesanan yang menunggu proses')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color($pendingOrdersCount > 0 ? 'warning' : 'success'),
            Stat::make('Grooming Pending', $pendingGroomingsCount) // Menggunakan hitungan dari GroomingResource
                ->description('Booking grooming menunggu konfirmasi')
                ->descriptionIcon('heroicon-m-sparkles') // Ganti ikon jika perlu (misal: heroicon-o-scissors)
                ->color($pendingGroomingsCount > 0 ? 'warning' : 'success'),
            Stat::make('Boarding Pending', $pendingBoardingsCount) // Berdasarkan logika BoardingResource
                ->description('Booking penitipan menunggu konfirmasi')
                ->descriptionIcon('heroicon-m-home-modern')
                ->color($pendingBoardingsCount > 0 ? 'warning' : 'success'),
            Stat::make('Artikel Terbit', $publishedPostsCount) // Menggunakan hitungan dari PostResource
                ->description('Jumlah artikel yang sudah dipublikasikan')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
        ];
    }
}
