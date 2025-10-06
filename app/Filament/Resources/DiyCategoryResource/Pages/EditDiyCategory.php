<?php

namespace App\Filament\Resources\DiyCategoryResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\DiyCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiyCategory extends EditRecord
{
    protected static string $resource = DiyCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
