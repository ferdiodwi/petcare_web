<?php

namespace App\Filament\Resources\BoardingResource\Pages;

use App\Filament\Resources\BoardingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBoarding extends EditRecord
{
    protected static string $resource = BoardingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
