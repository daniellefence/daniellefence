<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\PageViewsWidget;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\VisitorsWidget;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersOneDayWidget;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersSevenDayWidget;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersTwentyEightDayWidget;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsWidget;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsDurationWidget;
use BezhanSalleh\FilamentGoogleAnalytics\Widgets\MostVisitedPagesWidget;
use Filament\Actions;
use Filament\Pages\Page;

class TrafficAnalytics extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chart-bar-square';

    protected string $view = 'filament.pages.traffic-analytics';

    protected static ?string $slug = 'traffic-analytics';

    protected static string | \UnitEnum | null $navigationGroup = 'Dashboard & Analytics';

    protected static ?string $title = 'Website Analytics';

    protected static ?string $navigationLabel = 'Website Analytics';

    protected static ?int $navigationSort = 1;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('traffic_list')
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
                PageViewsWidget::class,
                VisitorsWidget::class,
                ActiveUsersOneDayWidget::class,
                ActiveUsersSevenDayWidget::class,
                ActiveUsersTwentyEightDayWidget::class,
                SessionsWidget::class,
                SessionsDurationWidget::class,
                MostVisitedPagesWidget::class,
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
                PageViewsWidget::class,
                VisitorsWidget::class,
                SessionsWidget::class,
                SessionsDurationWidget::class,
            ];
        }

        return [];
    }

    public function getFooterWidgets(): array
    {
        // Only load Google Analytics widgets if credentials are configured
        if ($this->hasAnalyticsCredentials()) {
            return [
                ActiveUsersOneDayWidget::class,
                ActiveUsersSevenDayWidget::class,
                ActiveUsersTwentyEightDayWidget::class,
                MostVisitedPagesWidget::class,
            ];
        }

        return [];
    }

    public function getFooterWidgetsColumns(): int|array
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