<?php

namespace App\Filament\Resources\CareerResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\CareerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCareers extends ListRecords
{
    protected static string $resource = CareerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
