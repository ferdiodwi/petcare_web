<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product; // Pastikan model Product di-import
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack'; // Anda bisa aktifkan jika mau
    protected static ?string $navigationGroup = 'Orders'; // Produk ini akan masuk ke grup 'Orders'

    public static function getNavigationLabel(): string
    {
        return 'Produk';
    }

    public static function getModelLabel(): string
    {
        return 'Produk';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Produk'; // Atau 'Daftar Produk'
    }

    /**
     * Menampilkan badge notifikasi di item navigasi.
     * Menghitung total jumlah produk.
     */
    public static function getNavigationBadge(): ?string
    {
        // Hitung total jumlah produk
        $totalProductsCount = static::getModel()::count();

        if ($totalProductsCount > 0) {
            return (string) $totalProductsCount;
        }

        return null; // Tidak menampilkan badge jika tidak ada produk
    }

    /**
     * Memberikan warna pada badge notifikasi.
     * Warna 'primary' (biru default) jika ada produk.
     */
    public static function getNavigationBadgeColor(): ?string
    {
        $totalProductsCount = static::getModel()::count(); // Bisa juga langsung cek apakah > 0

        if ($totalProductsCount > 0) {
            return 'primary'; // Warna badge (misalnya 'primary', 'secondary', 'gray')
        }

        return null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Produk')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->label('Harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\FileUpload::make('image_path')
                    ->label('Gambar Produk')
                    ->image(),
                Forms\Components\TextInput::make('stock')
                    ->label('Stok')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Gambar'),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Tambahkan filter jika perlu
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
