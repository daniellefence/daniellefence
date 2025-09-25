<?php

namespace App\Filament\Pages;

use Filament\Actions;
use Filament\Pages\Page;

class TrafficAnalytics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static string $view = 'filament.pages.traffic-analytics';

    protected static ?string $slug = 'traffic-analytics';

    protected static ?string $navigationGroup = 'Dashboard & Analytics';

    protected static ?string $title = 'Website Analytics';

    protected static ?string $navigationLabel = 'Website Analytics';

    protected static ?int $navigationSort = 1;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('traffic_list')
                ->label('View Raw Traffic Log')
                ->icon('heroicon-o-list-bullet')
                ->color('gray')
                ->url('/admin/traffic'),
        ];
    }

    public function getWidgets(): array
    {
        // Only load Google Analytics widgets if credentials are configured
        if ($this->hasAnalyticsCredentials()) {
            return [
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\PageViewsWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\VisitorsWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersOneDayWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersSevenDayWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersTwentyEightDayWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsDurationWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\MostVisitedPagesWidget::class,
            ];
        }

        return [];
    }

    public function getColumns(): int | array
    {
        return 12;
    }

    public function getHeaderWidgets(): array
    {
        // Only load Google Analytics widgets if credentials are configured
        if ($this->hasAnalyticsCredentials()) {
            return [
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\PageViewsWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\VisitorsWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsDurationWidget::class,
            ];
        }

        return [];
    }

    public function getFooterWidgets(): array
    {
        // Only load Google Analytics widgets if credentials are configured
        if ($this->hasAnalyticsCredentials()) {
            return [
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersOneDayWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersSevenDayWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersTwentyEightDayWidget::class,
                \BezhanSalleh\FilamentGoogleAnalytics\Widgets\MostVisitedPagesWidget::class,
            ];
        }

        return [];
    }

    public function getFooterWidgetsColumns(): int | array
    {
        return [
            'md' => 2,
            'xl' => 2,
        ];
    }

    /**
     * Check if Google Analytics credentials are configured
     */
    private function hasAnalyticsCredentials(): bool
    {
        $credentialsJson = env('GOOGLE_SERVICE_ACCOUNT_CREDENTIALS');

        if (!$credentialsJson || empty(trim($credentialsJson))) {
            return false;
        }

        $credentials = json_decode($credentialsJson, true);

        return $credentials &&
               json_last_error() === JSON_ERROR_NONE &&
               isset($credentials['type']) &&
               $credentials['type'] === 'service_account';
    }
}