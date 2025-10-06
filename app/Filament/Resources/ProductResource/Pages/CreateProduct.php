<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Photo;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function afterCreate(): void
    {
        // Handle photo uploads
        if ($this->data['photos'] ?? null) {
            foreach ($this->data['photos'] as $index => $photoPath) {
                Photo::create([
                    'product_id' => $this->record->id,
                    'path' => $photoPath,
                    'order' => $index,
                ]);
            }
        }
    }
}
