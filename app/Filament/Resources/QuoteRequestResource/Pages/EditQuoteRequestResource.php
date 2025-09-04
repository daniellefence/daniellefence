<?php

namespace App\Filament\Resources\QuoteRequestResource\Pages;

use App\Filament\Resources\QuoteRequestResource as Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuoteRequestResource extends EditRecord
{
    protected static string $resource = Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
