<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardingResource\Pages;
use App\Filament\Resources\BoardingResource\RelationManagers;
use App\Models\Boarding;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BoardingResource extends Resource
{
    protected static ?string $model = Boarding::class;

    // protected static ?string $navigationIcon = 'heroicon-o-home-modern'; // Ganti dengan ikon yang sesuai
        protected static ?string $navigationGroup = 'Bookings'; // Grup navigasi

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pet_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('species')
                    ->options([
                        'Anjing' => 'Anjing',
                        'Kucing' => 'Kucing',
                        'Kelinci' => 'Kelinci',
                        'Burung' => 'Burung',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('owner_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('owner_phone')
                    ->tel()
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('owner_email')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->required(),
                Forms\Components\Textarea::make('notes') // Menggunakan Textarea untuk notes
                    ->columnSpanFull()
                    ->default(null),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirm' => 'confirm',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('pending'),
                Forms\Components\TextInput::make('daily_rate')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\TextInput::make('total_cost')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pet_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('species'),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirm' => 'success',
                        'completed' => 'primary',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_cost')
                    ->numeric(decimalPlaces: 2, decimalSeparator: ',', thousandsSeparator: '.')
                    ->prefix('Rp ')
                    ->sortable(),
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
                // Tambahkan filter jika perlu
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('confirmBooking')
                    ->label('Konfirmasi Booking')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Boarding $record) {
                        if ($record->status === 'pending') {
                            $record->status = 'confirm';
                            $record->save();
                            Notification::make()
                                ->title('Booking dikonfirmasi')
                                ->body("Booking untuk {$record->pet_name} telah berhasil dikonfirmasi.")
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Gagal Konfirmasi')
                                ->body('Booking ini tidak dalam status pending.')
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(fn (Boarding $record): bool => $record->status === 'pending'), // Hanya tampil jika status 'pending'

                Action::make('cancelBooking')
                    ->label('Batalkan Booking')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation() // Meminta konfirmasi sebelum menjalankan aksi
                    ->action(function (Boarding $record) {
                        if (in_array($record->status, ['pending', 'confirm'])) {
                            $record->status = 'cancelled';
                            $record->save();
                            Notification::make()
                                ->title('Booking dibatalkan')
                                ->body("Booking untuk {$record->pet_name} telah berhasil dibatalkan.")
                                ->success()
                                ->send();
                        } else {
                             Notification::make()
                                ->title('Gagal Batalkan')
                                ->body('Booking ini tidak dapat dibatalkan.')
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(fn (Boarding $record): bool => in_array($record->status, ['pending', 'confirm'])), // Hanya tampil jika status 'pending' atau 'confirm'
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Anda juga bisa menambahkan bulk action untuk konfirmasi/pembatalan massal jika diperlukan
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBoardings::route('/'),
            'create' => Pages\CreateBoarding::route('/create'),
            // 'view' => Pages\ViewBoarding::route('/{record}'),
            'edit' => Pages\EditBoarding::route('/{record}/edit'),
        ];
    }
}
