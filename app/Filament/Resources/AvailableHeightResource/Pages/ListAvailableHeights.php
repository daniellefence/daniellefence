<?php

namespace App\Filament\Resources\AvailableHeightResource\Pages;

use App\Filament\Resources\AvailableHeightResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAvailableHeights extends ListRecords
{
    protected static string $resource = AvailableHeightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
