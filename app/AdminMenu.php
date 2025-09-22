<?php

namespace App;

use Illuminate\Support\Facades\Auth;

class AdminMenu
{
    public function get()
    {
        $general = [
            [
                'label' => 'General Settings',
                'icon' => 'settings',
                'route' => 'admin.general.read',
                'active' => ['admin.general.read'],
                'visible' => Auth::check() && auth()->user()->hasPermission('generalRead'),
            ],
            [
                'label' => 'LLMs.txt Editor',
                'icon' => 'documentation',
                'route' => 'admin.llms-txt.read',
                'active' => ['admin.llms-txt.read'],
                'visible' => Auth::check() && auth()->user()->hasPermission('generalRead'),
            ],
            [
                'label' => 'Sitemap.xml Editor',
                'icon' => 'map',
                'route' => 'admin.sitemap.read',
                'active' => ['admin.sitemap.read'],
                'visible' => Auth::check() && auth()->user()->hasPermission('generalRead'),
            ],
        ];
        $other = [
            [
                'label' => 'Activity',
                'icon' => 'activity',
                'route' => 'admin.read',
                'active' => ['admin.read'],
                'visible' => Auth::check() && auth()->user()->hasPermission('activityRead'),
            ],
            [
                'label' => 'Users',
                'icon' => 'user',
                'route' => 'admin.user.read',
                'active' => ['admin.user.create', 'admin.user.read', 'admin.user.update'],
                'visible' => Auth::check() && auth()->user()->hasPermission('userRead'),
            ],
            [
                'label' => 'Roles',
                'icon' => 'user',
                'route' => 'admin.roles.read',
                'active' => ['admin.roles.read', 'admin.roles.create', 'admin.roles.edit'],
                'visible' => Auth::check() && auth()->user()->hasPermission('userRead'),
            ],
            [
                'label' => 'Permissions',
                'icon' => 'user',
                'route' => 'admin.permissions.read',
                'active' => ['admin.permissions.read', 'admin.permissions.create', 'admin.permissions.edit'],
                'visible' => Auth::check() && auth()->user()->hasPermission('userRead'),
            ],
            [
                'label' => 'Traffic',
                'icon' => 'traffic',
                'route' => 'admin.traffic.read',
                'active' => ['admin.traffic.read'],
                'visible' => Auth::check() && auth()->user()->hasPermission('trafficRead'),
            ],
            [
                'label' => 'Contacts',
                'icon' => 'contact',
                'route' => 'admin.contact.read',
                'active' => ['admin.contact.read'],
                'visible' => Auth::check() && auth()->user()->hasPermission('contactRead'),
            ],
            [
                'label' => 'Quote Requests',
                'icon' => 'money',
                'route' => 'admin.quoterequest.read',
                'active' => ['admin.quoterequest.read'],
                'visible' => Auth::check() && auth()->user()->hasPermission('quoteRequestRead'),
            ],
            //            [
            //                'label' => 'Contacts',
            //                'icon' => 'contact',
            //                'route' => 'admin.contact.read',
            //                'active' => ['admin.contact.read'],
            //                'visible' => Auth::check() && auth()->user()->hasPermission('contactRead')
            //            ],
            [
                'label' => 'Reviews',
                'icon' => 'review',
                'route' => 'admin.review.read',
                'active' => ['admin.review.create', 'admin.review.read', 'admin.review.update'],
                'visible' => Auth::check() && auth()->user()->hasPermission('reviewRead'),
            ],
            [
                'label' => 'Careers',
                'icon' => 'career',
                'route' => 'admin.career.read',
                'active' => ['admin.career.create', 'admin.career.read', 'admin.career.update'],
                'visible' => Auth::check() && auth()->user()->hasPermission('careerRead'),
            ],
            [
                'label' => 'Applications',
                'icon' => 'career',
                'route' => 'admin.career.read',
                'active' => ['admin.career.read'],
                'visible' => Auth::check() && auth()->user()->hasPermission('careerRead'),
            ],
            [
                'label' => 'Blogs',
                'icon' => 'blog',
                'route' => 'admin.blog.read',
                'active' => ['admin.blog.category.read', 'admin.blog.create', 'admin.blog.read', 'admin.blog.update', 'admin.blog.preview'],
                'visible' => Auth::check() && auth()->user()->hasPermission('blogRead'),
            ],
            [
                'label' => 'FAQ',
                'icon' => 'question',
                'route' => 'admin.faq.read',
                'active' => ['admin.faq.read', 'admin.faq.create', 'admin.faq.update'],
                'visible' => Auth::check() && auth()->user()->hasPermission('faqRead'),
            ],
            [
                'label' => 'S.E.O.',
                'icon' => 'google',
                'route' => 'admin.seo.read',
                'active' => ['admin.seo.read'],
                'visible' => Auth::check() && auth()->user()->hasPermission('faqRead'),
            ],
            //            [
            //                'label' => 'Quote Requests',
            //                'icon' => 'money',
            //                'route' => 'admin.quoterequest.read',
            //                'active' => ['admin.quoterequest.read'],
            //                'visible' => Auth::check() && auth()->user()->hasPermission('quoteRequestRead')
            //            ],
            //            [
            //                'label' => 'Catalogs',
            //                'icon' => 'catalog',
            //                'route' => 'admin.catalogs.read',
            //                'active' => ['admin.catalogs.read'],
            //                'visible' => Auth::check() && auth()->user()->hasPermission('catalogsRead')
            //            ],
            [
                'label' => 'Google Analytics Code',
                'icon' => 'google',
                'route' => 'admin.google-analytics.read',
                'active' => ['admin.google-analytics.read'],
                'visible' => Auth::check() && auth()->user()->hasPermission('googleanalyticsRead'),
            ],
            [
                'label' => 'Areas We Serve',
                'icon' => 'map',
                'route' => 'admin.areas-we-serve.read',
                'active' => ['admin.areas-we-serve.read'],
                'visible' => Auth::check() && auth()->user()->hasPermission('areasweserveRead'),
            ],
            //            [
            //                'label' => 'Videos',
            //                'icon' => 'youtube',
            //                'route' => 'admin.videos.read',
            //                'active' => ['admin.videos.read'],
            //                'visible' => Auth::check() && auth()->user()->hasPermission('videosRead')
            //            ],
            [
                'label' => 'Specials',
                'icon' => 'store',
                'route' => 'admin.specials.read',
                'active' => ['admin.specials.read', 'admin.specials.create', 'admin.specials.update'],
                'visible' => Auth::check() && auth()->user()->hasPermission('specialsRead'),
            ],
            [
                'label' => 'Products',
                'icon' => 'store',
                'route' => 'admin.products.read',
                'active' => ['admin.products.read', 'admin.products.products', 'admin.products.category.*', 'admin.products.product.*', 'admin.products.subcategories'],
                'visible' => Auth::check() && auth()->user()->hasPermission('productRead'),
            ],
            [
                'label' => 'DIY Product Categories',
                'icon' => 'catalog',
                'route' => 'admin.diy.categories.index',
                'active' => ['admin.diy.categories.*'],
                'visible' => Auth::check() && auth()->user()->hasPermission('diyRead'),
            ],
            [
                'label' => 'DIY Products',
                'icon' => 'store',
                'route' => 'admin.diy.products.index',
                'active' => ['admin.diy.products.*'],
                'visible' => Auth::check() && auth()->user()->hasPermission('diyRead'),
            ],
            [
                'label' => 'DIY Colors',
                'icon' => 'photo',
                'route' => 'admin.diy.colors.index',
                'active' => ['admin.diy.colors.*'],
                'visible' => Auth::check() && auth()->user()->hasPermission('diyRead'),
            ],
            [
                'label' => 'DIY Heights',
                'icon' => 'trending-up',
                'route' => 'admin.diy.heights.index',
                'active' => ['admin.diy.heights.*'],
                'visible' => Auth::check() && auth()->user()->hasPermission('diyRead'),
            ],
            [
                'label' => 'DIY Spacings',
                'icon' => 'map',
                'route' => 'admin.diy.spacings.index',
                'active' => ['admin.diy.spacings.*'],
                'visible' => Auth::check() && auth()->user()->hasPermission('diyRead'),
            ],
        ];
        usort($other, function ($item1, $item2) {
            return $item1['label'] <=> $item2['label'];
        });

        return array_merge($general, $other);
    }
}
