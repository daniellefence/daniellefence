<?php

namespace App\Filament\Resources\KeywordResource\Pages;

use App\Filament\Resources\KeywordResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKeyword extends ViewRecord
{
    protected static string $resource = KeywordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
