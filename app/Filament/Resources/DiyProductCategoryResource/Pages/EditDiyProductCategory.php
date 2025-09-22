<?php

namespace App\Filament\Resources\DiyProductCategoryResource\Pages;

use App\Filament\Resources\DiyProductCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiyProductCategory extends EditRecord
{
    protected static string $resource = DiyProductCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
