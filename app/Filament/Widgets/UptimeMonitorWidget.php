<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class UptimeMonitorWidget extends Widget
{
    protected static string $view = 'filament.widgets.uptime-monitor';

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $sites = [
            'Main Website' => 'https://newdaniellefence.test',
            'Admin Panel' => 'https://newdaniellefence.test/admin',
        ];

        $uptimeData = [];

        foreach ($sites as $name => $url) {
            $cacheKey = 'uptime_' . md5($url);

            $status = Cache::remember($cacheKey, 300, function () use ($url) { // Cache for 5 minutes
                try {
                    $response = Http::timeout(10)->get($url);
                    return [
                        'status' => $response->successful() ? 'up' : 'down',
                        'response_time' => $response->handlerStats()['total_time'] ?? 0,
                        'status_code' => $response->status(),
                        'checked_at' => now(),
                    ];
                } catch (\Exception $e) {
                    return [
                        'status' => 'down',
                        'response_time' => 0,
                        'status_code' => 0,
                        'error' => $e->getMessage(),
                        'checked_at' => now(),
                    ];
                }
            });

            $uptimeData[$name] = array_merge(['url' => $url], $status);
        }

        // System metrics
        $systemMetrics = [
            'server_time' => now()->format('Y-m-d H:i:s'),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB',
            'disk_usage' => $this->getDiskUsage(),
        ];

        return [
            'sites' => $uptimeData,
            'system' => $systemMetrics,
        ];
    }

    private function getDiskUsage(): string
    {
        try {
            $bytes = disk_free_space('/');
            $total = disk_total_space('/');

            if ($bytes !== false && $total !== false) {
                $used = $total - $bytes;
                $percentage = round(($used / $total) * 100, 1);
                return $percentage . '% used';
            }
        } catch (\Exception $e) {
            // Ignore errors
        }

        return 'Unknown';
    }
}