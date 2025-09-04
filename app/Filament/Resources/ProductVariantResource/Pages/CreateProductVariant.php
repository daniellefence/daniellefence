<?php

namespace App\Filament\Resources\ProductVariantResource\Pages;

use App\Filament\Resources\ProductVariantResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductVariant extends CreateRecord
{
    protected static string $resource = ProductVariantResource::class;

    public function getTitle(): string
    {
        return 'Create Product Variant';
    }

    public function getSubheading(): string
    {
        return 'Add a new variant to an existing product with specific attributes, pricing, and inventory settings.';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}