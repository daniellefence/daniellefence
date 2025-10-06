<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;
use App\Models\Blog;
use App\Models\Product;
use App\Models\Category;
use App\Models\Faq;

class SystemStatsWidget extends Widget
{
    protected string $view = 'filament.widgets.system-stats';

    protected static ?int $sort = 4;

    protected function getViewData(): array
    {
        return [
            'totalUsers' => User::count(),
            'totalBlogs' => Blog::count(),
            'publishedBlogs' => Blog::where('published', true)->count(),
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalFaqs' => Faq::count(),
        ];
    }
}