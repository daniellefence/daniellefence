<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Laravel\Pulse\Facades\Pulse;

class PulseMetricsWidget extends Widget
{
    protected static string $view = 'filament.widgets.pulse-metrics';

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        try {
            // Check if Pulse tables exist
            if (!\Schema::hasTable('pulse_entries')) {
                throw new \Exception('Pulse tables not found');
            }

            // Get real Pulse data
            $requests = collect();
            $slowQueries = collect();
            $exceptions = collect();
            $queues = collect();

            // Get top routes from Pulse data
            try {
                $routeData = Pulse::values('route_hits', [])
                    ->take(10)
                    ->map(function ($entry) {
                        return (object) [
                            'key' => ['method' => 'GET', 'path' => $entry->key],
                            'value' => $entry->value
                        ];
                    });

                $requests = $routeData->isNotEmpty() ? $routeData : collect([
                    (object) ['key' => ['method' => 'GET', 'path' => '/'], 'value' => 0],
                ]);

                // Get traffic sources
                $trafficSources = Pulse::values('traffic_sources', [])->take(5);

                // Get total page views
                $totalPageViews = Pulse::values('page_views', ['total'])->first()?->value ?? 0;

            } catch (\Exception $e) {
                // Fallback to empty data if Pulse queries fail
                $requests = collect([
                    (object) ['key' => ['method' => 'GET', 'path' => 'No data yet'], 'value' => 0],
                ]);
                $trafficSources = collect();
                $totalPageViews = 0;
            }

            return [
                'requests' => $requests,
                'slow_queries' => $slowQueries,
                'exceptions' => $exceptions,
                'queues' => $queues,
                'traffic_sources' => $trafficSources ?? collect(),
                'total_page_views' => $totalPageViews,
                'pulse_enabled' => true,
            ];
        } catch (\Exception $e) {
            return [
                'pulse_enabled' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}