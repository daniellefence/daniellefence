<?php

namespace App\Filament\Resources\BlogcategoryResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\BlogcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBlogcategories extends ListRecords
{
    protected static string $resource = BlogcategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
