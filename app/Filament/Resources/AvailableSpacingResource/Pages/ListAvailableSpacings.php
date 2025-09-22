<?php

namespace App\Filament\Resources\AvailableSpacingResource\Pages;

use App\Filament\Resources\AvailableSpacingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAvailableSpacings extends ListRecords
{
    protected static string $resource = AvailableSpacingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
