<?php

namespace App\Filament\Resources\SpecialResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\SpecialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpecials extends ListRecords
{
    protected static string $resource = SpecialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
