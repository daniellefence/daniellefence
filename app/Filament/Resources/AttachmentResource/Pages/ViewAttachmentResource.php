<?php

namespace App\Filament\Resources\AttachmentResource\Pages;

use App\Filament\Resources\AttachmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAttachmentResource extends ViewRecord
{
    protected static string $resource = AttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}