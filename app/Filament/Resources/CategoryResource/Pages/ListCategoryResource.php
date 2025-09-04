<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource as Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryResource extends ListRecords
{
    protected static string $resource = Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
