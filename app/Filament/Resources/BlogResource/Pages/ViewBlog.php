<?php

namespace App\Filament\Resources\BlogResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\BlogResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBlog extends ViewRecord
{
    protected static string $resource = BlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
