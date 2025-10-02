<?php

namespace App\Filament\Resources\DiyOrderResource\Pages;

use App\Filament\Resources\DiyOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiyOrder extends EditRecord
{
    protected static string $resource = DiyOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
