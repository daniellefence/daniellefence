<?php

namespace App\Filament\Resources\GeneralSettingResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\GeneralSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGeneralSettings extends ListRecords
{
    protected static string $resource = GeneralSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
