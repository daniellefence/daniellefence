<?php

namespace App\Filament\Resources\BlogcategoryResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\BlogcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBlogcategory extends ViewRecord
{
    protected static string $resource = BlogcategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
