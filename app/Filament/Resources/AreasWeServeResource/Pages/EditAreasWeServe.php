<?php

namespace App\Filament\Resources\AreasWeServeResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\AreasWeServeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAreasWeServe extends EditRecord
{
    protected static string $resource = AreasWeServeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
