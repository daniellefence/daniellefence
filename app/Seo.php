<?php

namespace App;

use App\Models\Blog;
use App\Models\GeneralSetting;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Seo
{
    public function routes(): array
    {
        return [
            'home' => 'Home',
            'fence-gates' => 'Fence and Gates',
            'commercial' => 'Commercial',
            'discounts-deals' => 'Discounts and Deals',
            'about-us' => 'About Us',
            'contact' => 'Contact',
            'kitchens-grills' => 'Kitchens and Grills',
            'fire-features' => 'Fire Features',
            'railings-pavers' => 'Railings and Pavers',
            'outdoor-living-spaces' => 'Outdoor Living Spaces',
            'faq' => 'F.A.Q.',
            'reviews' => 'Reviews',
            'request-a-quote' => 'Request a Quote',
        ];
    }

    public function meta($type)
    {
        try {
            $route = Route::currentRouteName();
            $seo = \App\Models\Seo::where([
                ['route', '=', $route],
            ])->first();

            switch ($type) {
                case 'title':
                    if ($seo && !empty($seo->title)) {
                        return $this->defaultTitle().' | '.$seo->title;
                    }
                    if ($route == 'blog.read') {
                        $blog = Blog::findOrFail(request('id'));
                        return $this->defaultTitle().' | '.$blog->title;
                    }
                    // Handle product pages dynamically
                    if ($route == 'product.slug') {
                        $categorySlug = request()->route('category_slug');
                        $productSlug = request()->route('product_slug');
                        if ($categorySlug && $productSlug) {
                            try {
                                $product = $this->findProductBySlug($categorySlug, $productSlug);
                                if ($product) {
                                    return $this->defaultTitle().' | '.$product->title;
                                }
                            } catch (\Exception $e) {
                                \Log::error("SEO: Error finding product for slugs {$categorySlug}/{$productSlug}: " . $e->getMessage());
                            }
                        }
                    }
                    return $this->defaultTitle();

                case 'description':
                    if ($seo && !empty($seo->description)) {
                        return $seo->description;
                    }
                    if ($route == 'blog.read') {
                        $blog = Blog::findOrFail(request('id'));
                        return Str::limit($blog->content, 200);
                    }
                    // Handle product pages dynamically
                    if ($route == 'product.slug') {
                        $categorySlug = request()->route('category_slug');
                        $productSlug = request()->route('product_slug');
                        if ($categorySlug && $productSlug) {
                            try {
                                $product = $this->findProductBySlug($categorySlug, $productSlug);
                                if ($product && !empty($product->description)) {
                                    return Str::limit(strip_tags($product->description), 200);
                                }
                            } catch (\Exception $e) {
                                \Log::error("SEO: Error finding product for slugs {$categorySlug}/{$productSlug}: " . $e->getMessage());
                            }
                        }
                    }
                    return $this->defaultDescription();

                case 'keywords':
                    if ($seo && !empty($seo->keywords)) {
                        return $this->defaultKeywords().', '.$seo->keywords;
                    }
                    if ($route == 'blog.read') {
                        $blog = Blog::findOrFail(request('id'));
                        if ($blog->keywords) {
                            return $this->defaultKeywords().', '.$blog->keywords;
                        }
                    }
                    // Handle product pages dynamically
                    if ($route == 'product.slug') {
                        $categorySlug = request()->route('category_slug');
                        $productSlug = request()->route('product_slug');
                        if ($categorySlug && $productSlug) {
                            try {
                                $product = $this->findProductBySlug($categorySlug, $productSlug);
                                if ($product) {
                                    $category = $product->category;
                                    $categoryKeywords = $category ? $category->title : '';
                                    return $this->defaultKeywords().', '.$product->title.($categoryKeywords ? ', '.$categoryKeywords : '');
                                }
                            } catch (\Exception $e) {
                                \Log::error("SEO: Error finding product for slugs {$categorySlug}/{$productSlug}: " . $e->getMessage());
                            }
                        }
                    }
                    return $this->defaultKeywords();

                default:
                    // Return appropriate default for unknown types
                    return $this->defaultTitle();
            }
        } catch (\Exception $e) {
            // Log error but return safe defaults to prevent layout failures
            \Log::error("SEO meta error for type '{$type}': " . $e->getMessage());

            switch ($type) {
                case 'title':
                    return $this->defaultTitle();
                case 'description':
                    return $this->defaultDescription();
                case 'keywords':
                    return $this->defaultKeywords();
                default:
                    return $this->defaultTitle();
            }
        }
    }

    public function defaultTitle()
    {
        try {
            if (!\Schema::hasTable('general_settings')) {
                return 'Danielle Fence & Outdoor Living';
            }
            $setting = GeneralSetting::where([
                ['key', '=', 'default_site_title'],
            ])->first();
            return $setting ? $setting->value : 'Danielle Fence & Outdoor Living';
        } catch (\Exception $e) {
            return 'Danielle Fence & Outdoor Living';
        }
    }

    public function defaultDescription()
    {
        try {
            if (!\Schema::hasTable('general_settings')) {
                return 'Quality fencing and outdoor living solutions since 1976';
            }
            $setting = GeneralSetting::where([
                ['key', '=', 'default_site_description'],
            ])->first();
            return $setting ? $setting->value : 'Quality fencing and outdoor living solutions since 1976';
        } catch (\Exception $e) {
            return 'Quality fencing and outdoor living solutions since 1976';
        }
    }

    public function defaultKeywords()
    {
        try {
            if (!\Schema::hasTable('general_settings')) {
                return 'fence, fencing, outdoor living, vinyl fence, aluminum fence';
            }
            $setting = GeneralSetting::where([
                ['key', '=', 'default_site_keywords'],
            ])->first();
            return $setting ? $setting->value : 'fence, fencing, outdoor living, vinyl fence, aluminum fence';
        } catch (\Exception $e) {
            return 'fence, fencing, outdoor living, vinyl fence, aluminum fence';
        }
    }

    /**
     * Find a product by category and product slugs
     */
    private function findProductBySlug($categorySlug, $productSlug)
    {
        $categories = \App\Models\Category::all();
        $category = $categories->first(function ($cat) use ($categorySlug) {
            return Str::slug($cat->title) === $categorySlug;
        });

        if (!$category) {
            return null;
        }

        $products = Product::where('category_id', $category->id)->get();
        return $products->first(function ($prod) use ($productSlug) {
            return Str::slug($prod->title) === $productSlug;
        });
    }
}
