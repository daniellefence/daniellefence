<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlog extends EditRecord
{
    protected static string $resource = BlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->tooltip('Preview this blog post as it will appear to visitors'),
            Actions\DeleteAction::make()
                ->tooltip('Permanently delete this blog post and all associated media'),
        ];
    }

    public function getTitle(): string 
    {
        return 'Edit Blog Post';
    }

    public function getSubheading(): string
    {
        return 'Update your blog content, modify publishing settings, or add new media. Changes are saved automatically as drafts. Use the publish toggle to control visibility on your website.';
    }
}