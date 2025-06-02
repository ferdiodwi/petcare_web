<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\ItemsRelationManager;
use App\Models\Order; // Pastikan model Order di-import
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    // protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    // Biarkan navigationGroup sebagai 'Orders'
    protected static ?string $navigationGroup = 'Orders'; // Anda bisa ganti ke 'Manajemen Pesanan' jika mau

    // Label yang akan ditampilkan di navigasi untuk resource ini
    public static function getNavigationLabel(): string
    {
        return 'Pesanan';
    }

    // Label singular untuk model (misal: "Edit Pesanan X")
    public static function getModelLabel(): string
    {
        return 'Pesanan';
    }

    // Label plural untuk model (misal: "Daftar Pesanan")
    public static function getPluralModelLabel(): string
    {
        return 'Pesanan'; // atau 'Daftar Pesanan'
    }

    /**
     * Menampilkan badge notifikasi di item navigasi.
     * Menghitung jumlah pesanan dengan status 'pending'.
     */
    public static function getNavigationBadge(): ?string
    {
        // Hitung jumlah pesanan dengan status 'pending'
        // Pastikan namespace Model\Order sudah benar dan kolom status ada di tabel orders
        $pendingOrdersCount = static::getModel()::where('status', 'pending')->count();

        if ($pendingOrdersCount > 0) {
            return (string) $pendingOrdersCount;
        }

        return null;
    }

    /**
     * Memberikan warna pada badge notifikasi.
     * Warna 'warning' (kuning) jika ada pesanan pending.
     */
    public static function getNavigationBadgeColor(): ?string
    {
        $pendingOrdersCount = static::getModel()::where('status', 'pending')->count();

        if ($pendingOrdersCount > 0) {
            return 'warning'; // Warna badge (bisa 'primary', 'success', 'warning', 'danger', 'info')
        }

        return null;
    }


    // ... (sisa kode form, table, getRelations, getPages Anda tetap sama seperti sebelumnya) ...
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_name')
                    ->label('Nama Pelanggan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('address')
                    ->label('Alamat')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('total_amount')
                    ->label('Total Pembayaran')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\Select::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'pending' => 'Pending',
                        'proses' => 'Diproses',
                        'dikirim' => 'Dikirim',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('payment_proof_path')
                    ->label('Bukti Pembayaran')
                    ->image()
                    ->disk('public')
                    ->directory('payment-proofs')
                    ->columnSpanFull()
                    ->visible(fn (string $operation, ?Order $record): bool => $operation === 'edit' && $record?->status === 'pending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('customer_name')->label('Nama Pelanggan')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('total_amount')->label('Total')->money('IDR')->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()->searchable()
                    ->label('Status')
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'proses' => 'info',
                        'dikirim' => 'primary',
                        'selesai' => 'success',
                        'dibatalkan' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\ImageColumn::make('payment_proof_path')
                    ->label('Bukti Bayar')
                    ->disk('public')
                    ->defaultImageUrl(url('/images/placeholder.png')), // Pastikan path placeholder benar
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Order')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'), // Pastikan Anda memiliki halaman ViewOrder jika rute ini ada
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
