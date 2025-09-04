<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource as Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductResource extends ListRecords
{
    protected static string $resource = Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
