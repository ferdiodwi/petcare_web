<?php

namespace App\Filament\Resources\BoardingResource\Pages;

use App\Filament\Resources\BoardingResource;
use App\Enums\BoardingStatus; // <-- Import Enum yang baru dibuat
use App\Models\Boarding;      // <-- Import Model Boarding
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab; // <-- Import Tab
use Illuminate\Database\Eloquent\Builder;

class ListBoardings extends ListRecords
{
    protected static string $resource = BoardingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // Tambahkan method ini untuk Tabs
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua Boarding') // Anda bisa mengganti labelnya
                ->badge(Boarding::query()->count()), // Badge untuk semua data
            'pending' => Tab::make(BoardingStatus::PENDING->getLabel()) // Menggunakan label dari Enum
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', BoardingStatus::PENDING))
                ->badge(Boarding::query()->where('status', BoardingStatus::PENDING)->count())
                ->badgeColor('warning'),
            'confirm' => Tab::make(BoardingStatus::confirm->getLabel()) // Menggunakan label dari Enum
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', BoardingStatus::confirm))
                ->badge(Boarding::query()->where('status', BoardingStatus::confirm)->count())
                ->badgeColor('success'),
            'cancelled' => Tab::make(BoardingStatus::CANCELLED->getLabel()) // Menggunakan label dari Enum
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', BoardingStatus::CANCELLED))
                ->badge(Boarding::query()->where('status', BoardingStatus::CANCELLED)->count())
                ->badgeColor('danger'),
        ];
    }
}
