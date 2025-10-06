<?php

namespace App\Filament\Resources\DiyProductResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\DiyProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiyProduct extends EditRecord
{
    protected static string $resource = DiyProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
