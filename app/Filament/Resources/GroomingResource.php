<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroomingResource\Pages;
// use App\Filament\Resources\GroomingResource\RelationManagers; // Jika ada relasi
use App\Models\Grooming;
use App\Enums\GroomingKategori;
use App\Enums\GroomingStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope; // Jika menggunakan soft deletes
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification; // Pastikan ini di-import jika belum

class GroomingResource extends Resource
{
    protected static ?string $model = Grooming::class;

    // protected static ?string $navigationIcon = 'heroicon-o-scissors'; // Ganti dengan ikon yang sesuai

    protected static ?string $navigationGroup = 'Bookings'; // Grup navigasi

    // Method untuk menampilkan badge notifikasi di navigasi
    public static function getNavigationBadge(): ?string
    {
        // Hitung jumlah grooming yang statusnya PENDING
        $pendingCount = static::getModel()::where('status', GroomingStatus::PENDING)->count();

        return $pendingCount > 0 ? (string) $pendingCount : null;
    }

    // Method opsional untuk memberi warna pada badge notifikasi
    public static function getNavigationBadgeColor(): ?string
    {
        // Jika ada yang pending, beri warna 'warning' (kuning), jika tidak, tidak perlu warna khusus
        return static::getModel()::where('status', GroomingStatus::PENDING)->count() > 0 ? 'warning' : null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('kategori')
                    ->options(GroomingKategori::class) // Menggunakan Enum untuk opsi
                    ->required(),
                Forms\Components\TextInput::make('harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\DatePicker::make('tanggal')
                    ->required(),
                Forms\Components\TimePicker::make('jam')
                    ->required()
                    ->seconds(false), // Jika tidak memerlukan detik
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('catatan')
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options(GroomingStatus::class) // Menggunakan Enum untuk opsi
                    ->required()
                    ->default(GroomingStatus::PENDING), // Default status saat membuat baru dari admin
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->badge() // Tampilkan sebagai badge
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jam')
                    ->time('H:i'), // Format waktu
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan default, bisa ditampilkan user
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge() // Tampilkan status sebagai badge dengan warna dari Enum
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options(GroomingKategori::class),
                Tables\Filters\SelectFilter::make('status')
                    ->options(GroomingStatus::class),
                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('tanggal_dari'),
                        Forms\Components\DatePicker::make('tanggal_sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tanggal_dari'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal', '>=', $date),
                            )
                            ->when(
                                $data['tanggal_sampai'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('confirm_booking')
                    ->label('Konfirmasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Grooming $record) {
                        if ($record->status == GroomingStatus::PENDING) {
                            $record->status = GroomingStatus::CONFIRMED;
                            $record->save();
                            Notification::make() // Menggunakan import Filament\Notifications\Notification
                                ->title('Booking Confirmed')
                                ->success()
                                ->send();
                        } else {
                             Notification::make()
                                ->title('Booking cannot be confirmed')
                                ->body('This booking is not in pending state.')
                                ->warning()
                                ->send();
                        }
                    })
                    ->visible(fn (Grooming $record): bool => $record->status == GroomingStatus::PENDING),

                Action::make('cancel_booking')
                    ->label('Batal')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Grooming $record) {
                        if ($record->status == GroomingStatus::PENDING || $record->status == GroomingStatus::CONFIRMED) {
                            $record->status = GroomingStatus::CANCELLED;
                            $record->save();
                             Notification::make()
                                ->title('Booking Cancelled')
                                ->success()
                                ->send();
                        } else {
                             Notification::make()
                                ->title('Booking cannot be cancelled')
                                ->body('This booking is already cancelled or in an uncancelable state.')
                                ->warning()
                                ->send();
                        }
                    })
                    ->visible(fn (Grooming $record): bool => $record->status == GroomingStatus::PENDING || $record->status == GroomingStatus::CONFIRMED),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('confirm_selected')
                        ->label('Confirm Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $records->each(function (Grooming $record) {
                                if ($record->status == GroomingStatus::PENDING) {
                                    $record->status = GroomingStatus::CONFIRMED;
                                    $record->save();
                                }
                            });
                            Notification::make()
                                ->title('Selected bookings processed')
                                ->body('Pending bookings have been confirmed.')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers jika ada
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroomings::route('/'),
            'create' => Pages\CreateGrooming::route('/create'),
            // 'view' => Pages\ViewGrooming::route('/{record}'),
            'edit' => Pages\EditGrooming::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderByRaw("FIELD(status, '".GroomingStatus::PENDING->value."', '".GroomingStatus::CONFIRMED->value."', '".GroomingStatus::CANCELLED->value."')")
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam', 'asc');
    }
}
