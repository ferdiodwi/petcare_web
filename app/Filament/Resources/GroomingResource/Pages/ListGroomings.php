<?php

namespace App\Filament\Resources\GroomingResource\Pages;

use App\Filament\Resources\GroomingResource;
use App\Enums\GroomingStatus; // Import Enum Status
use App\Models\Grooming;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab; // Import Tab
use Illuminate\Database\Eloquent\Builder;

class ListGroomings extends ListRecords
{
    protected static string $resource = GroomingResource::class;

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
            'all' => Tab::make('All Groomings'),
            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', GroomingStatus::PENDING))
                ->badge(Grooming::query()->where('status', GroomingStatus::PENDING)->count())
                ->badgeColor('warning'),
            'confirmed' => Tab::make('Confirmed')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', GroomingStatus::CONFIRMED))
                ->badge(Grooming::query()->where('status', GroomingStatus::CONFIRMED)->count())
                ->badgeColor('success'),
            'cancelled' => Tab::make('Cancelled')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', GroomingStatus::CANCELLED))
                ->badge(Grooming::query()->where('status', GroomingStatus::CANCELLED)->count())
                ->badgeColor('danger'),
        ];
    }
}
