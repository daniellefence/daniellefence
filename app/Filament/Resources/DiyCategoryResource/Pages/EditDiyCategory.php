<?php

namespace App\Filament\Resources\DiyCategoryResource\Pages;

use App\Filament\Resources\DiyCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiyCategory extends EditRecord
{
    protected static string $resource = DiyCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
