<?php

namespace App\Filament\Resources\ReviewResource\Pages;

use App\Filament\Resources\ReviewResource;
use App\Services\GoogleReviewsService;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListReviews extends ListRecords
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('fetch_google_reviews')
                ->label('Fetch Google Reviews')
                ->icon('heroicon-o-arrow-path')
                ->color('success')
                ->action(function () {
                    $service = app(GoogleReviewsService::class);
                    $result = $service->fetchLatestReviews();
                    
                    if ($result['success']) {
                        Notification::make()
                            ->title('Google Reviews Fetched Successfully')
                            ->body($result['message'])
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Failed to Fetch Google Reviews')
                            ->body($result['message'])
                            ->danger()
                            ->send();
                    }
                })
                ->requiresConfirmation()
                ->modalHeading('Fetch Google Reviews')
                ->modalDescription('This will fetch the latest reviews from Google and add new 4+ star reviews to your database. Existing reviews will be skipped.')
                ->modalSubmitActionLabel('Fetch Reviews'),
            Actions\CreateAction::make(),
        ];
    }
}