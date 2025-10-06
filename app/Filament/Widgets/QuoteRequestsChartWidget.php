<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\QuoteRequest;
use Carbon\Carbon;

class QuoteRequestsChartWidget extends ChartWidget
{
    protected ?string $heading = 'Quote Requests (Last 30 Days)';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('M j');
            $data[] = QuoteRequest::whereDate('created_at', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Quote Requests',
                    'data' => $data,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
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