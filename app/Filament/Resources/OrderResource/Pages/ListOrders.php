<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResourceResource;
use App\Enums\BoardingStatus; // <-- Import Enum yang baru dibuat;use App\Models\Order;
use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource;
// use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab; // <-- Import Tab
use Illuminate\Database\Eloquent\Builder;
// use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
// use Filament\Resources\Pages\ListRecords;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Filament\Forms;



    class ListOrders extends ListRecords
    {
        protected static string $resource = OrderResource::class;

protected function getHeaderActions(): array
    {
         return [
            Action::make('Export PDF')
                ->form([
                    Forms\Components\Select::make('periode')
                        ->label('Pilih Periode')
                        ->options([
                            'daily' => 'Harian (Hari ini)',
                            'weekly' => 'Mingguan (7 hari terakhir)',
                            'monthly' => 'Bulanan (30 hari terakhir)',
                        ])
                        ->required(),
                ])
                ->action(function (array $data) {
                    // Filter data berdasarkan pilihan
                    $query = Order::query();

                    if ($data['periode'] === 'daily') {
                        $query->whereDate('created_at', today());
                    } elseif ($data['periode'] === 'weekly') {
                        $query->whereBetween('created_at', [now()->subDays(7), now()]);
                    } elseif ($data['periode'] === 'monthly') {
                        $query->whereBetween('created_at', [now()->subDays(30), now()]);
                    }

                    $orders = $query->get();

                    // Buat PDF view
                    $pdf = Pdf::loadView('exports.orders-pdf', ['orders' => $orders]);

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->stream();
                    }, 'laporan-pesanan.pdf');
                }),
        ];
    }

        public function getTabs(): array
        {
            return [
                'all' => Tab::make('Semua Pesanan')
                    ->badge(Order::query()->count()),

                'pending' => Tab::make(OrderStatus::PENDING->getLabel())
                    ->modifyQueryUsing(fn (Builder $query) => $query->where('status', OrderStatus::PENDING->value))
                    ->badge(Order::query()->where('status', OrderStatus::PENDING->value)->count())
                    ->badgeColor('warning'),

                'proses' => Tab::make(OrderStatus::PROSES->getLabel())
                    ->modifyQueryUsing(fn (Builder $query) => $query->where('status', OrderStatus::PROSES->value))
                    ->badge(Order::query()->where('status', OrderStatus::PROSES->value)->count())
                    ->badgeColor('info'),

                'dikirim' => Tab::make(OrderStatus::SHIPPED->getLabel())  // ganti DIKIRIM jadi SHIPPED
                    ->modifyQueryUsing(fn (Builder $query) => $query->where('status', OrderStatus::SHIPPED->value))
                    ->badge(Order::query()->where('status', OrderStatus::SHIPPED->value)->count())
                    ->badgeColor('primary'),

                'selesai' => Tab::make(OrderStatus::SELESAI->getLabel())
                    ->modifyQueryUsing(fn (Builder $query) => $query->where('status', OrderStatus::SELESAI->value))
                    ->badge(Order::query()->where('status', OrderStatus::SELESAI->value)->count())
                    ->badgeColor('success'),

                'dibatalkan' => Tab::make(OrderStatus::CANCELED->getLabel())
                    ->modifyQueryUsing(fn (Builder $query) => $query->where('status', OrderStatus::CANCELED->value))
                    ->badge(Order::query()->where('status', OrderStatus::CANCELED->value)->count())
                    ->badgeColor('danger'),
            ];
        }
    }
