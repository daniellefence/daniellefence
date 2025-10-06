<?php

namespace App\Filament\Resources\BlogcategoryResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\BlogcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlogcategory extends EditRecord
{
    protected static string $resource = BlogcategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
