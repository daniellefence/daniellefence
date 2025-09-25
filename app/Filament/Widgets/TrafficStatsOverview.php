<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TrafficStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Today\'s Visitors', \App\Models\Traffic::whereDate('created_at', today())->count())
                ->description('Unique page views today')
                ->descriptionIcon('heroicon-m-eye')
                ->color('primary'),

            Stat::make('This Week', \App\Models\Traffic::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count())
                ->description('Page views this week')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),

            Stat::make('This Month', \App\Models\Traffic::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count())
                ->description('Page views this month')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),

            Stat::make('All Time', \App\Models\Traffic::count())
                ->description('Total page views recorded')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('warning'),
        ];
    }
}
