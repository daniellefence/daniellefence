<?php

namespace App\Filament\Resources\GeneralSettingResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\GeneralSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGeneralSetting extends ViewRecord
{
    protected static string $resource = GeneralSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
