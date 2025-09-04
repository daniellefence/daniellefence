<?php

namespace App\Filament\Resources\ProductVariantResource\Pages;

use App\Filament\Resources\ProductVariantResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProductVariant extends ViewRecord
{
    protected static string $resource = ProductVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Product Variant Details';
    }

    public function getSubheading(): string
    {
        return 'View complete information about this product variant including specifications, pricing, and inventory status.';
    }
}