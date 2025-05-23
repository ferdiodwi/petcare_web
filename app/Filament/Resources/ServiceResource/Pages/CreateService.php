<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    public function getTitle(): string
    {
        return 'Buat Layanan Baru';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Transform features array format
        if (isset($data['features']) && is_array($data['features'])) {
            $data['features'] = array_map(function ($item) {
                return $item['feature'] ?? $item;
            }, $data['features']);
        }

        return $data;
    }
}
