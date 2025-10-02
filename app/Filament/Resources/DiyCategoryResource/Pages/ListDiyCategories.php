<?php

namespace App\Filament\Resources\DiyCategoryResource\Pages;

use App\Filament\Resources\DiyCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiyCategories extends ListRecords
{
    protected static string $resource = DiyCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
