<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Photo;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load existing photos for the form
        $data['photos'] = $this->record->photos()->orderBy('order')->pluck('path')->toArray();

        return $data;
    }

    protected function afterSave(): void
    {
        // Delete all existing photos
        $this->record->photos()->delete();

        // Create new photos from uploaded files
        if ($this->data['photos'] ?? null) {
            $order = 0;
            foreach ($this->data['photos'] as $photoPath) {
                Photo::create([
                    'product_id' => $this->record->id,
                    'path' => $photoPath,
                    'order' => $order++,
                ]);
            }
        }
    }
}
