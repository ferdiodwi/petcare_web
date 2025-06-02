<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post; // Pastikan model Post di-import
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text'; // Ikon untuk navigasi

    // protected static ?string $navigationGroup = 'Konten'; // Opsional: jika ingin dikelompokkan

    // Menambahkan label untuk navigasi dan model
    public static function getNavigationLabel(): string
    {
        return 'Artikel'; // Label yang tampil di navigasi
    }

    public static function getModelLabel(): string
    {
        return 'Artikel'; // Label singular untuk model (misal: "Edit Artikel X")
    }

    public static function getPluralModelLabel(): string
    {
        return 'Artikel'; // Label plural untuk model (misal: "Daftar Artikel")
    }

    // Method untuk menampilkan badge notifikasi di navigasi
    // Mengubah untuk menampilkan jumlah artikel yang SUDAH dipublikasikan
    public static function getNavigationBadge(): ?string
    {
        // Hitung jumlah artikel dimana is_published adalah true
        $count = static::getModel()::where('is_published', true)->count();

        return $count > 0 ? (string) $count : null; // Tampilkan count jika lebih dari 0, jika tidak, jangan tampilkan badge
    }

    // Method opsional untuk memberi warna pada badge notifikasi
    // Mengubah warna untuk badge jumlah artikel yang sudah dipublikasikan
    public static function getNavigationBadgeColor(): ?string
    {
        // Jika ada artikel yang sudah dipublikasikan, beri warna 'success' (hijau) atau 'info' (biru)
        // Di sini kita gunakan 'success'
        return static::getModel()::where('is_published', true)->count() > 0 ? 'success' : null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul') // Label untuk field
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                        if ($operation !== 'create') {
                            return;
                        }
                        $set('slug', Str::slug($state));
                    }),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug') // Label untuk field
                    ->required()
                    ->maxLength(255)
                    ->unique(Post::class, 'slug', ignoreRecord: true),

                Forms\Components\FileUpload::make('image')
                    ->label('Gambar Sampul') // Label untuk field
                    ->image()
                    ->directory('posts') // Pastikan direktori ini ada dan writable
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_published')
                    ->label('Status Publikasi') // Label untuk field
                    ->helperText('Aktifkan jika artikel ini ingin ditampilkan untuk umum.')
                    ->onIcon('heroicon-s-check-circle') // Opsional: ikon saat aktif
                    ->offIcon('heroicon-s-x-circle') // Opsional: ikon saat non-aktif
                    ->onColor('success') // Opsional: warna saat aktif
                    ->offColor('danger') // Opsional: warna saat non-aktif
                    ->required()
                    ->default(true),

                Forms\Components\RichEditor::make('content')
                    ->label('Konten Artikel') // Label untuk field
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar'), // Header kolom
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul') // Header kolom
                    ->searchable()
                    ->limit(50) // Opsional: batasi panjang teks di tabel
                    ->tooltip(fn (Post $record): string => $record->title ?? ''), // Opsional: tooltip untuk judul panjang
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug') // Header kolom
                    ->searchable()
                    ->limit(30),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Terbit') // Header kolom
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat') // Header kolom
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan default jika perlu
                 Tables\Columns\TextColumn::make('updated_at') // Tambahan kolom update
                    ->label('Terakhir Diperbarui')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Status Publikasi')
                    ->trueLabel('Sudah Terbit')
                    ->falseLabel('Belum Terbit (Draft)')
                    ->placeholder('Semua Status'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // ->label('Lihat')
                Tables\Actions\EditAction::make(), // ->label('Ubah')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // ->label('Hapus Terpilih')
                ]),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
            // Tambahkan halaman view jika diperlukan
            // 'view' => Pages\ViewPost::route('/{record}'),
        ];
    }
}
