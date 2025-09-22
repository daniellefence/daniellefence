<?php

namespace App\Filament\Resources\DiyProductResource\Pages;

use App\Filament\Resources\DiyProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiyProduct extends EditRecord
{
    protected static string $resource = DiyProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
