<?php

namespace App\Filament\Resources\AttachmentResource\Pages;

use App\Filament\Resources\AttachmentResource as Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttachmentResource extends ListRecords
{
    protected static string $resource = Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
