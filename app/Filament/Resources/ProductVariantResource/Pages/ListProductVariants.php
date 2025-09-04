<?php

namespace App\Filament\Resources\ProductVariantResource\Pages;

use App\Filament\Resources\ProductVariantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductVariants extends ListRecords
{
    protected static string $resource = ProductVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create Variant')
                ->tooltip('Add a new product variant with specific attributes and pricing'),
        ];
    }

    public function getTitle(): string 
    {
        return 'Product Variants';
    }

    public function getSubheading(): string
    {
        return 'Manage product variants with different colors, sizes, materials, and pricing. Use variants to offer customers multiple options for each product while maintaining organized inventory.';
    }
}