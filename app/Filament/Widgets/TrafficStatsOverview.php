<?php

namespace App\Filament\Widgets;

use App\Models\Traffic;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TrafficStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Today\'s Visitors', Traffic::whereDate('created_at', today())->count())
                ->description('Unique page views today')
                ->descriptionIcon('heroicon-m-eye')
                ->color('primary'),

            Stat::make('This Week', Traffic::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count())
                ->description('Page views this week')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),

            Stat::make('This Month', Traffic::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count())
                ->description('Page views this month')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),

            Stat::make('All Time', Traffic::count())
                ->description('Total page views recorded')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('warning'),
        ];
    }
}
