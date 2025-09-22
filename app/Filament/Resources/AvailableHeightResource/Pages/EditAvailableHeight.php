<?php

namespace App\Filament\Resources\AvailableHeightResource\Pages;

use App\Filament\Resources\AvailableHeightResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAvailableHeight extends EditRecord
{
    protected static string $resource = AvailableHeightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
