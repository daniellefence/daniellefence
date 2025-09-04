<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource as Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactResource extends ListRecords
{
    protected static string $resource = Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
