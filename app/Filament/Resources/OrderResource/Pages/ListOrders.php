<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResourceResource;
use App\Enums\BoardingStatus; // <-- Import Enum yang baru dibuat;use App\Models\Order;
use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab; // <-- Import Tab
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

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
        'all' => Tab::make('Semua Boarding')
            ->badge(Order::query()->count()),

        'pending' => Tab::make(OrderStatus::PENDING->getLabel())
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', OrderStatus::PENDING))
            ->badge(Order::query()->where('status', OrderStatus::PENDING)->count())
            ->badgeColor('warning'),

        'proses' => Tab::make(OrderStatus::PROSES->getLabel())
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', OrderStatus::PROSES))
            ->badge(Order::query()->where('status', OrderStatus::PROSES)->count())
            ->badgeColor('info'),

        'dikirim' => Tab::make(OrderStatus::DIKIRIM->getLabel())
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', OrderStatus::DIKIRIM))
            ->badge(Order::query()->where('status', OrderStatus::DIKIRIM)->count())
            ->badgeColor('primary'),

        'selesai' => Tab::make(OrderStatus::SELESAI->getLabel())
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', OrderStatus::SELESAI))
            ->badge(Order::query()->where('status', OrderStatus::SELESAI)->count())
            ->badgeColor('success'),

        'dibatalkan' => Tab::make(OrderStatus::DIBATALKAN->getLabel())
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', OrderStatus::DIBATALKAN))
            ->badge(Order::query()->where('status', OrderStatus::DIBATALKAN)->count())
            ->badgeColor('danger'),
    ];
}
}
