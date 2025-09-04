<?php

namespace App\Filament\Resources\AttachmentResource\Pages;

use App\Filament\Resources\AttachmentResource as Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttachmentResource extends EditRecord
{
    protected static string $resource = Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
