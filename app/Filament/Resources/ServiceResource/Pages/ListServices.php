<?php

// app/Filament/Resources/ServiceResource/Pages/ListServices.php
namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Layanan Baru'),
        ];
    }

    public function getTitle(): string
    {
        return 'Daftar Layanan';
    }
}
