<?php

namespace App\Filament\Resources\AvailableColorResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\AvailableColorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAvailableColors extends ListRecords
{
    protected static string $resource = AvailableColorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
