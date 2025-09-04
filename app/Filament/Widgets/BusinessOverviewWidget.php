<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\Contact;
use App\Models\Product;
use App\Models\QuoteRequest;
use App\Models\User;
use App\Models\Visitor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class BusinessOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Quote Requests', QuoteRequest::count())
                ->description('All time quote requests')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('success')
                ->chart($this->getQuoteRequestsChart()),

            Stat::make('New Quotes This Month', QuoteRequest::whereMonth('created_at', now()->month)->count())
                ->description(($this->getQuoteRequestsGrowth() >= 0 ? '+' : '') . $this->getQuoteRequestsGrowth() . '% from last month')
                ->descriptionIcon($this->getQuoteRequestsGrowth() >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($this->getQuoteRequestsGrowth() >= 0 ? 'success' : 'danger'),

            Stat::make('Active Products', Product::count())
                ->description('Total products in catalog')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info'),

            Stat::make('Contact Inquiries', Contact::count())
                ->description('All contact form submissions')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning'),

            Stat::make('Website Visitors', Visitor::count())
                ->description('Total unique visitors tracked')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->chart($this->getVisitorsChart()),

            Stat::make('Published Blog Posts', Blog::where('status', 'published')->count())
                ->description('Live content articles')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('success'),
        ];
    }

    private function getQuoteRequestsChart(): array
    {
        return QuoteRequest::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();
    }

    private function getQuoteRequestsGrowth(): int
    {
        $thisMonth = QuoteRequest::whereMonth('created_at', now()->month)->count();
        $lastMonth = QuoteRequest::whereMonth('created_at', now()->subMonth()->month)->count();
        
        if ($lastMonth === 0) {
            return $thisMonth > 0 ? 100 : 0;
        }
        
        return (int) round((($thisMonth - $lastMonth) / $lastMonth) * 100);
    }

    private function getVisitorsChart(): array
    {
        return Visitor::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();
    }

    public static function canView(): bool
    {
        return auth()->user()?->can('view_analytics') ?? false;
    }
}