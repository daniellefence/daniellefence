<?php

namespace App\Filament\Pages;

use Filament\Actions;
use Filament\Pages\Page;

class TrafficAnalytics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static string $view = 'filament.pages.traffic-analytics';

    protected static ?string $slug = 'traffic-analytics';

    protected static ?string $navigationGroup = 'Analytics';

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

    public function getColumns(): int | array
    {
        return 12;
    }

    public function getHeaderWidgets(): array
    {
        return [
            \BezhanSalleh\FilamentGoogleAnalytics\Widgets\PageViewsWidget::class,
            \BezhanSalleh\FilamentGoogleAnalytics\Widgets\VisitorsWidget::class,
            \BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsWidget::class,
            \BezhanSalleh\FilamentGoogleAnalytics\Widgets\SessionsDurationWidget::class,
        ];
    }

    public function getFooterWidgets(): array
    {
        return [
            \BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersOneDayWidget::class,
            \BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersSevenDayWidget::class,
            \BezhanSalleh\FilamentGoogleAnalytics\Widgets\ActiveUsersTwentyEightDayWidget::class,
            \BezhanSalleh\FilamentGoogleAnalytics\Widgets\MostVisitedPagesWidget::class,
        ];
    }

    public function getFooterWidgetsColumns(): int | array
    {
        return [
            'md' => 2,
            'xl' => 2,
        ];
    }
}