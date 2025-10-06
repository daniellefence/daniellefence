<?php

namespace App\Filament\Resources\GeneralSettingResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\GeneralSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGeneralSetting extends EditRecord
{
    protected static string $resource = GeneralSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
