<?php

namespace App\Filament\Resources\AvailableSpacingResource\Pages;

use App\Filament\Resources\AvailableSpacingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAvailableSpacing extends EditRecord
{
    protected static string $resource = AvailableSpacingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
