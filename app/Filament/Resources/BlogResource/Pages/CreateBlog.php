<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlog extends CreateRecord
{
    protected static string $resource = BlogResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['author_id'] = auth()->id();
        
        return $data;
    }

    public function getTitle(): string 
    {
        return 'Create New Blog Post';
    }

    public function getSubheading(): string
    {
        return 'Create engaging blog content with rich text, images, and proper SEO. Fill in the title to auto-generate a slug, add categories, and set publishing options. Use the rich editor for formatting and include a featured image for better engagement.';
    }
}