<?php

namespace App\Filament\Resources\BlogCategoryResource\Pages;

use App\Filament\Resources\BlogCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBlogCategories extends ListRecords
{
    protected static string $resource = BlogCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create New Category')
                ->tooltip('Add a new blog category to organize your content'),
        ];
    }

    public function getTitle(): string 
    {
        return 'Blog Categories';
    }

    public function getSubheading(): string
    {
        return 'Organize your blog posts with categories and subcategories. Create hierarchical structures to help visitors navigate your content. Use bulk actions to quickly publish or unpublish multiple categories.';
    }
}