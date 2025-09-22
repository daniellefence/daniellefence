<?php

namespace App\Filament\Resources\DiyProductResource\Pages;

use App\Filament\Resources\DiyProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDiyProduct extends ViewRecord
{
    protected static string $resource = DiyProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
