<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use App\Models\Blog;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListBlogs extends ListRecords
{
    protected static string $resource = BlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create New Blog Post')
                ->tooltip('Add a new blog post with rich content, images, and SEO optimization'),
        ];
    }

    public function getTitle(): string 
    {
        return 'Blog Posts';
    }

    public function getSubheading(): string
    {
        return 'Manage your blog content, categories, and publishing schedule. Use filters to find specific posts and bulk actions to publish or organize content efficiently.';
    }
}