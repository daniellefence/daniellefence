<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\Page;
use App\Models\Product;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;
use RalphJSmit\Laravel\SEO\Models\SEO;

class SEOAnalyticsWidget extends Widget
{
    protected static string $view = 'filament.widgets.seo-analytics';
    protected static ?int $sort = 6;
    protected static ?string $pollingInterval = '10m';

    public function getViewData(): array
    {
        return Cache::remember('seo_analytics_widget', 600, function () {
            return [
                'seo_coverage' => $this->getSEOCoverage(),
                'content_insights' => $this->getContentInsights(),
                'optimization_suggestions' => $this->getOptimizationSuggestions(),
            ];
        });
    }

    private function getSEOCoverage(): array
    {
        $totalPages = Page::count();
        $totalBlogs = Blog::count();
        $totalProducts = Product::count();
        $totalContent = $totalPages + $totalBlogs + $totalProducts;

        $seoRecords = SEO::count();
        $coverage = $totalContent > 0 ? round(($seoRecords / $totalContent) * 100) : 0;

        return [
            'total_content' => $totalContent,
            'seo_records' => $seoRecords,
            'coverage_percent' => $coverage,
            'missing' => max(0, $totalContent - $seoRecords),
            'status' => $coverage >= 80 ? 'excellent' : ($coverage >= 60 ? 'good' : ($coverage >= 40 ? 'fair' : 'poor')),
        ];
    }

    private function getContentInsights(): array
    {
        return [
            'blog_posts' => [
                'published' => Blog::where('status', 'published')->count(),
                'drafts' => Blog::where('status', 'draft')->count(),
                'scheduled' => Blog::where('status', 'scheduled')->count(),
            ],
            'pages' => [
                'total' => Page::count(),
                'recent' => Page::where('created_at', '>=', now()->subDays(30))->count(),
            ],
            'products' => [
                'total' => Product::count(),
                'with_descriptions' => Product::whereNotNull('description')->count(),
            ],
        ];
    }

    private function getOptimizationSuggestions(): array
    {
        $suggestions = [];

        // Check for missing SEO data
        $totalContent = Page::count() + Blog::count() + Product::count();
        $seoRecords = SEO::count();
        if ($seoRecords < $totalContent) {
            $suggestions[] = [
                'type' => 'seo',
                'priority' => 'high',
                'title' => 'Missing SEO Data',
                'description' => ($totalContent - $seoRecords) . ' pages are missing SEO metadata',
                'action' => 'Add SEO titles and descriptions',
            ];
        }

        // Check for content gaps
        $blogCount = Blog::where('status', 'published')->count();
        if ($blogCount < 5) {
            $suggestions[] = [
                'type' => 'content',
                'priority' => 'medium',
                'title' => 'Limited Blog Content',
                'description' => 'Only ' . $blogCount . ' published blog posts',
                'action' => 'Create more blog content for better SEO',
            ];
        }

        // Check for product descriptions
        $productsWithoutDesc = Product::whereNull('description')->count();
        if ($productsWithoutDesc > 0) {
            $suggestions[] = [
                'type' => 'product',
                'priority' => 'medium',
                'title' => 'Product Descriptions Missing',
                'description' => $productsWithoutDesc . ' products lack descriptions',
                'action' => 'Add detailed product descriptions',
            ];
        }

        return $suggestions;
    }

    public static function canView(): bool
    {
        return auth()->user()?->can('view_seo') ?? true;
    }
}