<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    // protected static ?string $navigationIcon = 'heroicon-o-users'; // Bisa diaktifkan jika mau

    protected static ?string $navigationGroup = 'Akun'; // Sudah "Akun", bagus!

    // Menambahkan label untuk navigasi dan model
    public static function getNavigationLabel(): string
    {
        return 'Pelanggan';
    }

    public static function getModelLabel(): string
    {
        return 'Pelanggan';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Pelanggan'; // Atau 'Daftar Pelanggan'
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Pelanggan') // Label untuk field
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email') // Label untuk field
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label('No. Telepon') // Label untuk field
                    ->tel()
                    ->required(),
                Forms\Components\Textarea::make('address')
                    ->label('Alamat') // Label untuk field
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pelanggan') // Header kolom
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email') // Header kolom
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('No. Telepon') // Header kolom
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat') // Header kolom
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar') // Header kolom
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Jika ada 'updated_at' yang ingin ditampilkan:
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->label('Diperbarui Pada')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Tambahkan filter jika perlu, dengan label berbahasa Indonesia
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Label biasanya otomatis diterjemahkan jika locale 'id'
                // Jika tidak, ->label('Ubah')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Label biasanya otomatis diterjemahkan
                    // Jika tidak, ->label('Hapus Terpilih')
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
