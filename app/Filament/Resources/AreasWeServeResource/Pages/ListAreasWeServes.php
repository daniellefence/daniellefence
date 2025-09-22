<?php

namespace App\Filament\Resources\AreasWeServeResource\Pages;

use App\Filament\Resources\AreasWeServeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAreasWeServes extends ListRecords
{
    protected static string $resource = AreasWeServeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
