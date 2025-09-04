<?php

namespace App\Filament\Resources\BlogCategoryResource\Pages;

use App\Filament\Resources\BlogCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlogCategory extends EditRecord
{
    protected static string $resource = BlogCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->tooltip('Preview this category and see its blog posts'),
            Actions\DeleteAction::make()
                ->tooltip('Permanently delete this category. Any blog posts will be uncategorized.'),
        ];
    }

    public function getTitle(): string 
    {
        return 'Edit Blog Category';
    }

    public function getSubheading(): string
    {
        return 'Modify category details, change hierarchy, or update descriptions. Changes to the slug will affect the category URL. Be careful when deleting categories that contain blog posts.';
    }
}