<?php

namespace App\Filament\Resources\SEOResource\Pages;

use App\Filament\Resources\SEOResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSEO extends ListRecords
{
    protected static string $resource = SEOResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create SEO Configuration')
                ->tooltip('Add SEO settings for pages, blog posts, or products'),
            Actions\Action::make('seo_audit')
                ->label('Run SEO Audit')
                ->icon('heroicon-o-clipboard-document-check')
                ->action(function () {
                    // This could trigger an SEO audit process
                    $this->dispatch('seo-audit-started');
                })
                ->color('warning')
                ->tooltip('Analyze all content for SEO optimization opportunities'),
        ];
    }

    public function getTitle(): string 
    {
        return 'SEO Management';
    }

    public function getSubheading(): string
    {
        return 'Manage SEO settings for all your content. Optimize titles, descriptions, keywords, and social media sharing to improve search engine visibility and click-through rates.';
    }
}