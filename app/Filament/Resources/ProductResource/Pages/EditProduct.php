<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
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
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load existing photos from JSON column (new system)
        // If JSON column is empty, try loading from photo records (legacy system)
        if (empty($data['photos']) || !is_array($data['photos'])) {
            $data['photos'] = $this->record->photoRecords()->orderBy('order')->pluck('path')->toArray();
        }

        return $data;
    }

    protected function afterSave(): void
    {
        // The photos are now stored in the JSON column automatically by Filament
        // We can optionally sync to photo records for backwards compatibility
        if ($this->data['photos'] ?? null) {
            // Delete existing photo records
            $this->record->photoRecords()->delete();

            // Create new photo records from the JSON data
            $order = 0;
            foreach ($this->data['photos'] as $photoPath) {
                Photo::create([
                    'product_id' => $this->record->id,
                    'path' => $photoPath,
                    'order' => $order++,
                ]);
            }
        } else {
            // If no photos, delete all photo records
            $this->record->photoRecords()->delete();
        }
    }
}
