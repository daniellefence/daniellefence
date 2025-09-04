<?php

namespace App\Filament\Resources\SEOResource\Pages;

use App\Filament\Resources\SEOResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSEO extends EditRecord
{
    protected static string $resource = SEOResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('preview_serp')
                ->label('Preview SERP')
                ->icon('heroicon-o-magnifying-glass')
                ->modalContent(function () {
                    $title = $this->record->title ?? 'Your SEO Title Here';
                    $description = $this->record->description ?? 'Your meta description will appear here...';
                    $url = $this->record->canonical_url ?? 'https://yoursite.com/page-url';
                    
                    return view('filament.seo.serp-preview', [
                        'title' => $title,
                        'description' => $description,
                        'url' => $url,
                    ]);
                })
                ->modalHeading('Search Engine Results Preview')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Close')
                ->color('info'),
        ];
    }

    public function getTitle(): string
    {
        return 'Edit SEO Configuration';
    }

    public function getSubheading(): string
    {
        return 'Update SEO settings to improve search engine visibility and social media sharing for this content.';
    }
}