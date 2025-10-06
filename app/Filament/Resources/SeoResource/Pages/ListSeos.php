<?php

namespace App\Filament\Resources\SeoResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\SeoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeos extends ListRecords
{
    protected static string $resource = SeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
