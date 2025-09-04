<?php

namespace App\Filament\Resources\DIYOrderResource\Pages;

use App\Filament\Resources\DIYOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDIYOrder extends EditRecord
{
    protected static string $resource = DIYOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}