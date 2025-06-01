<?php

namespace App\Filament\Resources\GroomingResource\Pages;

use App\Filament\Resources\GroomingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGrooming extends EditRecord
{
    protected static string $resource = GroomingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
