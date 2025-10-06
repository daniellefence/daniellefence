<?php

namespace App\Filament\Resources\AreasWeServeResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\AreasWeServeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAreasWeServe extends ViewRecord
{
    protected static string $resource = AreasWeServeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
