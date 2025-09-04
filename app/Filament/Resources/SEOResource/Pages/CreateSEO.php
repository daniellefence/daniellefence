<?php

namespace App\Filament\Resources\SEOResource\Pages;

use App\Filament\Resources\SEOResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSEO extends CreateRecord
{
    protected static string $resource = SEOResource::class;

    public function getTitle(): string
    {
        return 'Create SEO Configuration';
    }

    public function getSubheading(): string
    {
        return 'Set up SEO optimization for your content including meta titles, descriptions, keywords, and social media sharing settings.';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}