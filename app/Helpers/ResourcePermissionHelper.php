<?php

namespace App\Helpers;

class ResourcePermissionHelper
{
    /**
     * Get permission check methods for a resource
     */
    public static function getPermissionMethods(string $permissionPrefix): string
    {
        return "
    public static function canAccess(): bool
    {
        return auth()->user()?->can('view_{$permissionPrefix}') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_{$permissionPrefix}') ?? false;
    }

    public static function canEdit(\$record): bool
    {
        return auth()->user()?->can('edit_{$permissionPrefix}') ?? false;
    }

    public static function canDelete(\$record): bool
    {
        return auth()->user()?->can('delete_{$permissionPrefix}') ?? false;
    }

    public static function canView(\$record): bool
    {
        return auth()->user()?->can('view_{$permissionPrefix}') ?? false;
    }";
    }

    /**
     * Resource to permission mapping
     */
    public static function getResourcePermissions(): array
    {
        return [
            'ProductResource' => 'products',
            'ContactResource' => 'contacts', 
            'FAQResource' => 'faqs',
            'DocumentResource' => 'documents',
            'CareerResource' => 'careers',
            'ApplicationResource' => 'applications',
            'ReviewResource' => 'reviews',
            'VisitorResource' => 'visitors',
            'CategoryResource' => 'categories',
            'QuoteRequestResource' => 'quotes',
            'BlogCategoryResource' => 'categories',
            'DocumentCategoryResource' => 'categories',
            'ActivityLogResource' => 'activity_logs',
        ];
    }
}