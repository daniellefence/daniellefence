<?php

namespace App\Filament\Resources\CareerResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\CareerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCareer extends EditRecord
{
    protected static string $resource = CareerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
