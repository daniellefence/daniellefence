<?php

namespace App\Filament\Resources\QuoteRequestResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\QuoteRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuoteRequests extends ListRecords
{
    protected static string $resource = QuoteRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
