<?php

namespace App;

use App\Models\Blog;
use App\Models\GeneralSetting;
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
            'diy' => 'DIY',
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
        $route = Route::currentRouteName();
        $seo = \App\Models\Seo::where([
            ['route', '=', $route],
        ])->first();

        switch ($type) {
            case 'title':
                if ($seo) {
                    return $this->defaultTitle().' | '.$seo->title;
                }
                if ($route == 'blog.read') {
                    $blog = Blog::findOrFail(request('id'));

                    return $this->defaultTitle().' | '.$blog->title;
                }
                break;
            case 'description':
                if ($seo) {
                    return $seo->description;
                }
                if ($route == 'blog.read') {
                    $blog = Blog::findOrFail(request('id'));

                    return Str::limit($blog->content, 200);
                }

                return $this->defaultDescription();
                break;
            case 'keywords':
                if ($seo) {
                    return $this->defaultKeywords().', '.$seo->keywords;
                }
                if ($route == 'blog.read') {
                    $blog = Blog::findOrFail(request('id'));
                    if ($blog->keywords) {
                        return $this->defaultKeywords().', '.$blog->keywords;
                    }

                    return $this->defaultKeywords();
                }

                return $this->defaultKeywords();
                break;
        }

        return null;
    }

    public function defaultTitle()
    {
        $setting = GeneralSetting::where([
            ['key', '=', 'default_site_title'],
        ])->first();
        return $setting ? $setting->value : 'Danielle Fence & Outdoor Living';
    }

    public function defaultDescription()
    {
        $setting = GeneralSetting::where([
            ['key', '=', 'default_site_description'],
        ])->first();
        return $setting ? $setting->value : 'Quality fencing and outdoor living solutions since 1976';
    }

    public function defaultKeywords()
    {
        $setting = GeneralSetting::where([
            ['key', '=', 'default_site_keywords'],
        ])->first();
        return $setting ? $setting->value : 'fence, fencing, outdoor living, vinyl fence, aluminum fence';
    }
}
