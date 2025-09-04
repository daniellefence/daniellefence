<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource as Resource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListMediaResource extends ListRecords
{
    protected static string $resource = Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Upload Files')
                ->icon('heroicon-o-cloud-arrow-up')
                ->color('primary')
                ->tooltip('Upload new media files to your library with metadata and SEO optimization'),
        ];
    }

    public function getTitle(): string 
    {
        return 'Media Library';
    }

    public function getSubheading(): string
    {
        return 'Manage all your website media files including images, documents, and videos. Upload new files, organize them into collections, add SEO metadata, and attach them to content. Use filters to find specific files and bulk actions to organize your media efficiently.';
    }
}
