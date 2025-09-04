<?php

namespace App\Filament\Resources\ProductVariantResource\Pages;

use App\Filament\Resources\ProductVariantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductVariant extends EditRecord
{
    protected static string $resource = ProductVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('duplicate')
                ->label('Duplicate Variant')
                ->icon('heroicon-o-document-duplicate')
                ->action(function () {
                    $newVariant = $this->record->replicate();
                    $newVariant->name = $this->record->name . ' (Copy)';
                    $newVariant->sku = null;
                    $newVariant->save();
                    
                    return redirect()->route('filament.admin.resources.product-variants.edit', $newVariant);
                })
                ->requiresConfirmation()
                ->color('warning'),
        ];
    }

    public function getTitle(): string
    {
        return 'Edit Product Variant';
    }

    public function getSubheading(): string
    {
        return 'Modify variant specifications, pricing, inventory, and media for this product option.';
    }
}