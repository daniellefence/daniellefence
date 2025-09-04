<?php

namespace App\Filament\Resources\BlogCategoryResource\Pages;

use App\Filament\Resources\BlogCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogCategory extends CreateRecord
{
    protected static string $resource = BlogCategoryResource::class;

    public function getTitle(): string 
    {
        return 'Create New Blog Category';
    }

    public function getSubheading(): string
    {
        return 'Create a new category to organize your blog posts. Categories can be hierarchical with parent-child relationships. Fill in the name to auto-generate a URL slug, and add an optional description for better SEO.';
    }
}