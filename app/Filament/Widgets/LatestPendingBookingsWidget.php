<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\GroomingResource;
use App\Filament\Resources\BoardingResource;
use App\Models\Grooming;
use App\Models\Boarding;
use App\Enums\GroomingStatus;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class LatestPendingBookingsWidget extends BaseWidget
{
    protected static ?string $heading = 'Booking Pending Terbaru';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 3; // Urutan widget

    public function table(Table $table): Table
    {
        // Mengambil data dari dua model dan menggabungkannya sulit dilakukan secara efisien
        // dalam satu query TableWidget standar. Cara paling mudah adalah menampilkan dua tabel terpisah
        // atau membuat query yang lebih kompleks atau view di database.
        // Untuk contoh ini, kita akan fokus pada Grooming Pending terlebih dahulu,
        // atau Anda bisa membuat dua widget terpisah.

        // Alternatif: Menampilkan Grooming Pending
        return $table
            ->query(
                Grooming::query()
                    ->where('status', GroomingStatus::PENDING) //
                    ->latest('tanggal') // Asumsi ada kolom 'tanggal'
                    ->limit(5)
            )
            ->heading('Grooming Pending Terbaru')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Pelanggan'), //
                Tables\Columns\TextColumn::make('kategori')->label('Kategori')->badge(), //
                Tables\Columns\TextColumn::make('tanggal')->date()->sortable(), //
                Tables\Columns\TextColumn::make('jam')->time('H:i'), //
            ])
            ->actions([
                Tables\Actions\Action::make('view_grooming')
                    ->label('Lihat')
                    ->url(fn (Grooming $record): string => GroomingResource::getUrl('edit', ['record' => $record])) // Ganti ke 'view' jika ada
                    ->icon('heroicon-o-eye'),
            ])
            ->emptyStateHeading('Tidak ada booking grooming pending saat ini.');

        // Jika ingin menampilkan Boarding Pending juga, Anda bisa membuat widget lain
        // atau menggunakan pendekatan yang lebih advanced untuk menggabungkan data.
    }
}
