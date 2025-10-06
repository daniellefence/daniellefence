<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Traffic;
use Carbon\Carbon;

class TrafficChart extends ChartWidget
{
    protected ?string $heading = 'Website Traffic (Last 30 Days)';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('M j');
            $data[] = Traffic::whereDate('created_at', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Page Views',
                    'data' => $data,
                    'borderColor' => 'rgb(142, 42, 42)',
                    'backgroundColor' => 'rgba(142, 42, 42, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}