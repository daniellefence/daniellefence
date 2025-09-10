<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\FAQ;
use App\Models\Product;
use App\Models\Special;
use App\Models\YouTubeVideo;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ContentManagementWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '5m';

    protected function getStats(): array
    {
        return [
            Stat::make('Blog Posts', Blog::count())
                ->description($this->getBlogDescription())
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            Stat::make('Products', Product::count())
                ->description('Total products available')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info'),

            Stat::make('Media Files', Media::count())
                ->description($this->getMediaDescription())
                ->descriptionIcon('heroicon-m-photo')
                ->color('warning'),

            Stat::make('FAQs & Videos', FAQ::count() . ' / ' . YouTubeVideo::count())
                ->description('Help content and videos')
                ->descriptionIcon('heroicon-m-question-mark-circle')
                ->color('secondary'),

            Stat::make('Active Specials', Special::where('is_active', true)->count())
                ->description('Currently running promotions')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('success'),
        ];
    }

    private function getBlogDescription(): string
    {
        $published = Blog::where('status', 'published')->count();
        $draft = Blog::where('status', 'draft')->count();
        return "{$published} published, {$draft} drafts";
    }

    private function getMediaDescription(): string
    {
        $totalSize = Media::sum('size');
        $sizeFormatted = $this->formatBytes($totalSize);
        return "Total size: {$sizeFormatted}";
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
        return auth()->user()?->can('view_content_stats') ?? true;
    }
}