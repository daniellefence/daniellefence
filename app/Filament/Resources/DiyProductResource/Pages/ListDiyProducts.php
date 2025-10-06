<?php

namespace App\Filament\Resources\DiyProductResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\DiyProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiyProducts extends ListRecords
{
    protected static string $resource = DiyProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
