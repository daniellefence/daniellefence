<?php

namespace App\Filament\Resources\DiyCategoryResource\Pages;

use App\Filament\Resources\DiyCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDiyCategory extends ViewRecord
{
    protected static string $resource = DiyCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
