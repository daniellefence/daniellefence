<?php

namespace App\Filament\Resources\CareerResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\CareerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCareer extends ViewRecord
{
    protected static string $resource = CareerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
