<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class QuickActionsWidget extends Widget
{
    protected static string $view = 'filament.widgets.quick-actions';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        return [
            'actions' => [
                [
                    'title' => 'Create New Blog Post',
                    'description' => 'Start writing a new blog article',
                    'icon' => 'heroicon-o-newspaper',
                    'color' => 'success',
                    'url' => '/admin/blogs/create',
                    'permission' => 'create_blog',
                ],
                [
                    'title' => 'Add New Product',
                    'description' => 'Add a product to the catalog',
                    'icon' => 'heroicon-o-cube',
                    'color' => 'info',
                    'url' => '/admin/product-resources/create',
                    'permission' => 'create_product',
                ],
                [
                    'title' => 'View Quote Requests',
                    'description' => 'Review customer quotes',
                    'icon' => 'heroicon-o-clipboard-document-list',
                    'color' => 'warning',
                    'url' => '/admin/quote-request-resources',
                    'permission' => 'view_quote_request',
                ],
                [
                    'title' => 'Manage Users',
                    'description' => 'User accounts and permissions',
                    'icon' => 'heroicon-o-users',
                    'color' => 'primary',
                    'url' => '/admin/user-resources',
                    'permission' => 'view_user',
                ],
                [
                    'title' => 'Site Settings',
                    'description' => 'Configure website settings',
                    'icon' => 'heroicon-o-cog-6-tooth',
                    'color' => 'secondary',
                    'url' => '/admin/site-settings',
                    'permission' => 'update_site_setting',
                ],
                [
                    'title' => 'Media Library',
                    'description' => 'Manage images and files',
                    'icon' => 'heroicon-o-photo',
                    'color' => 'purple',
                    'url' => '/admin/media-resources',
                    'permission' => 'view_media',
                ],
                [
                    'title' => 'Trash Bin',
                    'description' => 'Manage deleted items',
                    'icon' => 'heroicon-o-trash',
                    'color' => 'danger',
                    'url' => '/admin/trash-bin-resources',
                    'permission' => 'view_trash_bin',
                ],
                [
                    'title' => 'Performance Monitor',
                    'description' => 'Laravel Pulse dashboard',
                    'icon' => 'heroicon-o-chart-bar',
                    'color' => 'indigo',
                    'url' => '/admin/pulse',
                    'permission' => 'view_pulse',
                ],
            ],
        ];
    }

    public static function canView(): bool
    {
        return true;
    }
}