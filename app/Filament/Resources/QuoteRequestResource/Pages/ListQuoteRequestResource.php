<?php

namespace App\Filament\Resources\QuoteRequestResource\Pages;

use App\Filament\Resources\QuoteRequestResource as Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuoteRequestResource extends ListRecords
{
    protected static string $resource = Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
