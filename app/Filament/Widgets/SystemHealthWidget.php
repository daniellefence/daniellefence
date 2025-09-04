<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SystemHealthWidget extends Widget
{
    protected static string $view = 'filament.widgets.system-health';

    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = '30s';

    public function getViewData(): array
    {
        return [
            'database' => $this->checkDatabaseConnection(),
            'cache' => $this->checkCacheConnection(),
            'storage' => $this->checkStorageHealth(),
            'memory' => $this->getMemoryUsage(),
            'disk' => $this->getDiskUsage(),
        ];
    }

    private function checkDatabaseConnection(): array
    {
        try {
            DB::connection()->getPdo();
            return [
                'status' => 'healthy',
                'message' => 'Database connection is working',
                'color' => 'success'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Database connection failed',
                'color' => 'danger'
            ];
        }
    }

    private function checkCacheConnection(): array
    {
        try {
            Cache::put('health_check', 'ok', 5);
            $result = Cache::get('health_check');
            
            if ($result === 'ok') {
                return [
                    'status' => 'healthy',
                    'message' => 'Cache is working',
                    'color' => 'success'
                ];
            }
            
            return [
                'status' => 'warning',
                'message' => 'Cache may not be working properly',
                'color' => 'warning'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Cache connection failed',
                'color' => 'danger'
            ];
        }
    }

    private function checkStorageHealth(): array
    {
        try {
            Storage::put('health_check.txt', 'ok');
            $result = Storage::get('health_check.txt');
            Storage::delete('health_check.txt');
            
            if ($result === 'ok') {
                return [
                    'status' => 'healthy',
                    'message' => 'Storage is working',
                    'color' => 'success'
                ];
            }
            
            return [
                'status' => 'warning',
                'message' => 'Storage may not be working properly',
                'color' => 'warning'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Storage access failed',
                'color' => 'danger'
            ];
        }
    }

    private function getMemoryUsage(): array
    {
        $memoryUsage = memory_get_usage(true);
        $memoryLimit = $this->parseMemoryLimit(ini_get('memory_limit'));
        $usagePercent = $memoryLimit > 0 ? ($memoryUsage / $memoryLimit) * 100 : 0;

        return [
            'usage' => $this->formatBytes($memoryUsage),
            'limit' => $this->formatBytes($memoryLimit),
            'percent' => round($usagePercent, 1),
            'color' => $usagePercent > 80 ? 'danger' : ($usagePercent > 60 ? 'warning' : 'success')
        ];
    }

    private function getDiskUsage(): array
    {
        $path = storage_path();
        $freeBytes = disk_free_space($path);
        $totalBytes = disk_total_space($path);
        $usedBytes = $totalBytes - $freeBytes;
        $usagePercent = $totalBytes > 0 ? ($usedBytes / $totalBytes) * 100 : 0;

        return [
            'used' => $this->formatBytes($usedBytes),
            'total' => $this->formatBytes($totalBytes),
            'free' => $this->formatBytes($freeBytes),
            'percent' => round($usagePercent, 1),
            'color' => $usagePercent > 90 ? 'danger' : ($usagePercent > 80 ? 'warning' : 'success')
        ];
    }

    private function parseMemoryLimit(string $memoryLimit): int
    {
        if ($memoryLimit === '-1') {
            return 0; // Unlimited
        }

        $unit = strtolower(substr($memoryLimit, -1));
        $value = (int) $memoryLimit;

        switch ($unit) {
            case 'g':
                return $value * 1024 * 1024 * 1024;
            case 'm':
                return $value * 1024 * 1024;
            case 'k':
                return $value * 1024;
            default:
                return $value;
        }
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes === 0) return '0 B';

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = floor(log($bytes, 1024));
        $power = min($power, count($units) - 1);

        return round($bytes / (1024 ** $power), 2) . ' ' . $units[$power];
    }

    public static function canView(): bool
    {
        return auth()->user()?->can('view_pulse') ?? false;
    }
}