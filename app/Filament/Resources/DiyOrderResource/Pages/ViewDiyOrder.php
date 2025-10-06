<?php

namespace App\Filament\Resources\DiyOrderResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\DiyOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDiyOrder extends ViewRecord
{
    protected static string $resource = DiyOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
