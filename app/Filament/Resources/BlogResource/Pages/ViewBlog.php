<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBlog extends ViewRecord
{
    protected static string $resource = BlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->tooltip('Edit this blog post content, settings, or media'),
        ];
    }

    public function getTitle(): string 
    {
        return 'View Blog Post';
    }

    public function getSubheading(): string
    {
        return 'Review all blog post details including content, media, publishing status, and metadata. This is how the content appears in your admin system - visitors will see the formatted version on your website.';
    }
}