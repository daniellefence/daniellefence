<?php

namespace App\Filament\Resources\KeywordResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\KeywordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKeywords extends ListRecords
{
    protected static string $resource = KeywordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
