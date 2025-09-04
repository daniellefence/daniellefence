<?php

namespace App\Filament\Resources\ModifierResource\Pages;

use App\Filament\Resources\ModifierResource as Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditModifierResource extends EditRecord
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
