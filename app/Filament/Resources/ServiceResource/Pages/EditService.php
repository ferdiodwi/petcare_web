<?php
// app/Filament/Resources/ServiceResource/Pages/EditService.php
namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Lihat')
                ->icon('heroicon-m-eye'),
            Actions\DeleteAction::make()
                ->label('Hapus')
                ->icon('heroicon-m-trash')
                ->requiresConfirmation()
                ->modalHeading('Hapus Layanan')
                ->modalDescription('Apakah Anda yakin ingin menghapus layanan ini? Tindakan ini tidak dapat dibatalkan.')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->modalCancelActionLabel('Batal'),
            Actions\RestoreAction::make()
                ->label('Pulihkan')
                ->icon('heroicon-m-arrow-path'),
        ];
    }

    public function getTitle(): string
    {
        return 'Edit Layanan';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Transform features array format before saving
        if (isset($data['features']) && is_array($data['features'])) {
            $data['features'] = array_map(function ($item) {
                if (is_array($item)) {
                    return $item['feature'] ?? $item;
                }
                return $item;
            }, $data['features']);
        }

        // Add updated timestamp
        $data['updated_at'] = now();

        return $data;
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Layanan berhasil diperbarui')
            ->body('Perubahan pada layanan telah berhasil disimpan.');
    }

    protected function afterSave(): void
    {
        // Add any post-save logic here
        // For example, cache clearing, notifications, etc.
    }
}
