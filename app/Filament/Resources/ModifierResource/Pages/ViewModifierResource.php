<?php

namespace App\Filament\Resources\ModifierResource\Pages;

use App\Filament\Resources\ModifierResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewModifierResource extends ViewRecord
{
    protected static string $resource = ModifierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}