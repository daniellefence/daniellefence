<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Contact;
use App\Models\QuoteRequest;
use App\Models\Review;
use App\Models\Blog;
use App\Models\Product;
use App\Models\Traffic;
use App\Models\User;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Contact metrics
        $todayContacts = Contact::whereDate('created_at', today())->count();
        $weekContacts = Contact::where('created_at', '>=', now()->subWeek())->count();
        $totalContacts = Contact::count();

        // Quote metrics
        $todayQuotes = QuoteRequest::whereDate('created_at', today())->count();
        $weekQuotes = QuoteRequest::where('created_at', '>=', now()->subWeek())->count();
        $totalQuotes = QuoteRequest::count();

        // Content metrics
        $publishedBlogs = Blog::where('published', true)->count();
        $totalReviews = Review::where('hidden', false)->count();

        // Traffic metrics (last 7 days)
        $weeklyTraffic = Traffic::where('created_at', '>=', now()->subWeek())->count();
        $dailyTrafficChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $dailyTrafficChart[] = Traffic::whereDate('created_at', now()->subDays($i))->count();
        }

        // Product metrics
        $totalProducts = Product::count();

        // Conversion rate
        $conversionRate = $totalContacts > 0 ? round(($totalQuotes / $totalContacts) * 100, 1) : 0;

        return [
            Stat::make('Total Contacts', $totalContacts)
                ->description($todayContacts . ' new today, ' . $weekContacts . ' this week')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart($dailyTrafficChart),

            Stat::make('Quote Requests', $totalQuotes)
                ->description($todayQuotes . ' new today (' . $conversionRate . '% conversion)')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('info')
                ->chart([2, 5, 3, 8, 1, 6, $todayQuotes]),

            Stat::make('Weekly Traffic', $weeklyTraffic)
                ->description('Page views this week')
                ->descriptionIcon('heroicon-m-eye')
                ->color('primary')
                ->chart($dailyTrafficChart),

            Stat::make('Content Stats', $publishedBlogs)
                ->description($totalReviews . ' reviews, ' . $totalProducts . ' products')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('warning'),
        ];
    }
}