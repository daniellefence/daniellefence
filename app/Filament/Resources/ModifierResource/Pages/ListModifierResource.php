<?php

namespace App\Filament\Resources\ModifierResource\Pages;

use App\Filament\Resources\ModifierResource as Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListModifierResource extends ListRecords
{
    protected static string $resource = Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
