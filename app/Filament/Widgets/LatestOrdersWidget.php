<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource; // Untuk link ke resource jika perlu
use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrdersWidget extends BaseWidget
{
    protected static ?string $heading = 'Pesanan Terbaru';
    protected int | string | array $columnSpan = 'full'; // Mengambil lebar penuh
    protected static ?int $sort = 2; // Urutan widget di dashboard

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()->latest()->limit(5) // Ambil 5 pesanan terbaru
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Pesanan'),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama Pelanggan')
                    ->searchable(), //
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total Bayar')
                    ->money('IDR'), //
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge() //
                    ->color(fn (string $state): string => match ($state) { //
                        'pending' => 'warning',
                        'proses' => 'info',
                        'dikirim' => 'primary',
                        'selesai' => 'success',
                        'dibatalkan' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pesan')
                    ->dateTime('d M Y, H:i'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_order')
                    ->label('Lihat')
                    ->url(fn (Order $record): string => OrderResource::getUrl('view', ['record' => $record])) // Pastikan halaman view ada di OrderResource
                    ->icon('heroicon-o-eye'),
            ]);
    }
}
