<?php

namespace App\Filament\Resources\AvailableColorResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\AvailableColorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAvailableColor extends EditRecord
{
    protected static string $resource = AvailableColorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
