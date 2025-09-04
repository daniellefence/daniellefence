<?php

namespace App\Filament\Resources\DIYOrderResource\Widgets;

use App\Models\DIYOrder;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class DIYOrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        $pendingCount = DIYOrder::pending()->count();
        $todayCount = DIYOrder::today()->count();
        $weekCount = DIYOrder::thisWeek()->count();
        $totalCount = DIYOrder::count();

        return [
            Stat::make('Pending Orders', $pendingCount)
                ->description($pendingCount > 0 ? 'Needs immediate attention' : 'All caught up!')
                ->descriptionIcon($pendingCount > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($pendingCount > 0 ? 'warning' : 'success')
                ->extraAttributes([
                    'class' => $pendingCount > 0 ? 'animate-pulse' : '',
                ]),

            Stat::make('Today\'s Orders', $todayCount)
                ->description(Carbon::today()->format('F j, Y'))
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info')
                ->chart($this->getTodayOrdersChart()),

            Stat::make('This Week', $weekCount)
                ->description('Monday - ' . Carbon::now()->endOfWeek()->format('l'))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success')
                ->chart($this->getWeeklyOrdersChart()),

            Stat::make('Total Orders', $totalCount)
                ->description('All time DIY orders')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),
        ];
    }

    protected function getTodayOrdersChart(): array
    {
        // Get hourly data for today
        $hours = [];
        $counts = [];
        
        for ($i = 0; $i < 24; $i++) {
            $hourStart = Carbon::today()->addHours($i);
            $hourEnd = $hourStart->copy()->addHour();
            
            $count = DIYOrder::whereBetween('created_at', [$hourStart, $hourEnd])->count();
            $counts[] = $count;
        }

        return $counts;
    }

    protected function getWeeklyOrdersChart(): array
    {
        // Get daily data for this week
        $startOfWeek = Carbon::now()->startOfWeek();
        $counts = [];
        
        for ($i = 0; $i < 7; $i++) {
            $dayStart = $startOfWeek->copy()->addDays($i);
            $dayEnd = $dayStart->copy()->endOfDay();
            
            $count = DIYOrder::whereBetween('created_at', [$dayStart, $dayEnd])->count();
            $counts[] = $count;
        }

        return $counts;
    }
}