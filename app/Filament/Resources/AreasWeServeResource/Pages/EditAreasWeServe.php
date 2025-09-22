<?php

namespace App\Filament\Resources\AreasWeServeResource\Pages;

use App\Filament\Resources\AreasWeServeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAreasWeServe extends EditRecord
{
    protected static string $resource = AreasWeServeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
