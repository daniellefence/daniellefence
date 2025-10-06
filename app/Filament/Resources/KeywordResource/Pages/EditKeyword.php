<?php

namespace App\Filament\Resources\KeywordResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\KeywordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKeyword extends EditRecord
{
    protected static string $resource = KeywordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
