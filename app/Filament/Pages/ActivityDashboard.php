<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\RecentContactsWidget;
use App\Filament\Widgets\QuoteRequestsChartWidget;
use App\Filament\Widgets\SystemStatsWidget;
use App\Filament\Widgets\UptimeMonitorWidget;
use App\Filament\Widgets\PulseMetricsWidget;

class ActivityDashboard extends Dashboard
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home';

    protected static ?string $title = 'Activity Dashboard';

    protected static ?int $navigationSort = 1;

    public function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
            RecentContactsWidget::class,
            QuoteRequestsChartWidget::class,
            SystemStatsWidget::class,
            // Temporarily disabled due to performance issues
            // UptimeMonitorWidget::class,
            // PulseMetricsWidget::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 2;
    }
}
