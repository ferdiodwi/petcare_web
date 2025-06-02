<?php

namespace App\Filament\Widgets;

use App\Models\Order; // Menggunakan model Order
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pemasukan Bulanan'; // Judul widget diubah
    protected static ?string $pollingInterval = '60s'; // Interval refresh data (opsional)
    protected int | string | array $columnSpan = 'full'; // Mengambil lebar penuh
    protected static ?int $sort = 2; // Anda bisa mengatur urutan widget ini di dashboard

    protected function getData(): array
    {
        // Mengambil data tren total pemasukan dari model Order
        // berdasarkan kolom 'total_amount'
        $data = Trend::model(Order::class)
            ->between(
                start: now()->subMonth(), // Data untuk 30 hari terakhir
                end: now(),
            )
            ->perDay() // Agregasi per hari
            ->sum('total_amount'); // Menjumlahkan kolom 'total_amount'

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan per Hari (Rp)', // Label untuk dataset
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgb(75, 192, 192)', // Warna garis grafik
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)', // Warna area di bawah garis (opsional)
                    'tension' => 0.1, // Kelengkungan garis
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => \Carbon\Carbon::parse($value->date)->format('d M')), // Format tanggal untuk label sumbu X
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Tipe grafik (bisa 'line', 'bar', dll.)
    }
}
