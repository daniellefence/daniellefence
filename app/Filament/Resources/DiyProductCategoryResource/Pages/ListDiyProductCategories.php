<?php

namespace App\Filament\Resources\DiyProductCategoryResource\Pages;

use App\Filament\Resources\DiyProductCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiyProductCategories extends ListRecords
{
    protected static string $resource = DiyProductCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
