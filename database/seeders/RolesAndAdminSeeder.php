<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cache to avoid conflicts
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Create all required permissions
        $this->createPermissions();
        
        // Create roles and assign permissions
        $this->createRoles();
        
        // Create default admin user
        $this->createAdminUser();
    }

    private function createPermissions(): void
    {
        // Blog Management Permissions
        $blogPermissions = [
            'view_blogs',
            'create_blogs', 
            'edit_blogs',
            'delete_blogs',
            'publish_blogs'
        ];

        // Product Management Permissions
        $productPermissions = [
            'view_products',
            'create_products',
            'edit_products', 
            'delete_products',
            'publish_products'
        ];

        // Product Variant Permissions
        $productVariantPermissions = [
            'view_product_variants',
            'create_product_variants',
            'edit_product_variants',
            'delete_product_variants'
        ];

        // Media Management Permissions
        $mediaPermissions = [
            'view_media',
            'upload_media',
            'edit_media',
            'delete_media'
        ];

        // User Management Permissions
        $userPermissions = [
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'assign_roles'
        ];

        // Contact Management Permissions
        $contactPermissions = [
            'view_contacts',
            'create_contacts',
            'edit_contacts', 
            'delete_contacts'
        ];

        // Analytics Permissions
        $analyticsPermissions = [
            'view_visitors',
            'view_reviews'
        ];

        // HR Management Permissions
        $hrPermissions = [
            'view_careers',
            'create_careers',
            'edit_careers',
            'view_applications'
        ];

        // System Settings Permissions
        $systemPermissions = [
            'manage_settings',
            'view_activity_logs',
            'manage_seo',
            'view_pulse',
            'manage_gtm'
        ];

        // Category and Tag Management
        $categoryPermissions = [
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories'
        ];

        // Document Management
        $documentPermissions = [
            'view_documents',
            'create_documents',
            'edit_documents',
            'delete_documents'
        ];

        // FAQ Management 
        $faqPermissions = [
            'view_faqs',
            'create_faqs',
            'edit_faqs',
            'delete_faqs'
        ];

        // Quote Request Management
        $quotePermissions = [
            'view_quotes',
            'create_quotes',
            'edit_quotes',
            'delete_quotes'
        ];

        // Page Management
        $pagePermissions = [
            'view_pages',
            'create_pages',
            'edit_pages',
            'delete_pages',
            'publish_pages'
        ];

        // Special Offers Management
        $specialPermissions = [
            'view_specials',
            'create_specials',
            'edit_specials',
            'delete_specials'
        ];

        // YouTube Video Management
        $videoPermissions = [
            'view_videos',
            'create_videos',
            'edit_videos',
            'delete_videos'
        ];

        // Service Area Management
        $serviceAreaPermissions = [
            'view_service_areas',
            'create_service_areas',
            'edit_service_areas',
            'delete_service_areas'
        ];

        // Site Settings Management
        $settingsPermissions = [
            'view_settings',
            'edit_settings'
        ];

        // Additional System Permissions
        $additionalPermissions = [
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',
            'view_permissions',
            'view_attachments',
            'create_attachments',
            'edit_attachments',
            'delete_attachments',
            'view_modifiers',
            'create_modifiers',
            'edit_modifiers',
            'delete_modifiers',
            'manage_trash'
        ];

        // Combine all permissions
        $allPermissions = array_merge(
            $blogPermissions,
            $productPermissions,
            $productVariantPermissions,
            $mediaPermissions,
            $userPermissions,
            $contactPermissions,
            $analyticsPermissions,
            $hrPermissions,
            $systemPermissions,
            $categoryPermissions,
            $documentPermissions,
            $faqPermissions,
            $quotePermissions,
            $pagePermissions,
            $specialPermissions,
            $videoPermissions,
            $serviceAreaPermissions,
            $settingsPermissions,
            $additionalPermissions
        );

        // Create all permissions
        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }

    private function createRoles(): void
    {
        // SuperAdmin - Full access to everything
        $superAdmin = Role::firstOrCreate(['name' => 'SuperAdmin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Owner - Business owner with near-full access
        $owner = Role::firstOrCreate(['name' => 'Owner']);
        $ownerPermissions = [
            // Full content management
            'view_blogs', 'create_blogs', 'edit_blogs', 'delete_blogs', 'publish_blogs',
            'view_products', 'create_products', 'edit_products', 'delete_products', 'publish_products',
            'view_product_variants', 'create_product_variants', 'edit_product_variants', 'delete_product_variants',
            'view_documents', 'create_documents', 'edit_documents', 'delete_documents',
            'view_faqs', 'create_faqs', 'edit_faqs', 'delete_faqs',
            'view_pages', 'create_pages', 'edit_pages', 'delete_pages', 'publish_pages',
            'view_specials', 'create_specials', 'edit_specials', 'delete_specials',
            'view_videos', 'create_videos', 'edit_videos', 'delete_videos',
            'view_service_areas', 'create_service_areas', 'edit_service_areas', 'delete_service_areas',
            // Media management
            'view_media', 'upload_media', 'edit_media', 'delete_media',
            // User management
            'view_users', 'create_users', 'edit_users', 'assign_roles',
            'view_roles', 'create_roles', 'edit_roles', 'delete_roles',
            // Business operations
            'view_contacts', 'create_contacts', 'edit_contacts', 'delete_contacts',
            'view_quotes', 'create_quotes', 'edit_quotes', 'delete_quotes',
            'view_visitors', 'view_reviews',
            // HR management
            'view_careers', 'create_careers', 'edit_careers', 'view_applications',
            // Categories and organization
            'view_categories', 'create_categories', 'edit_categories', 'delete_categories',
            'view_attachments', 'create_attachments', 'edit_attachments', 'delete_attachments',
            'view_modifiers', 'create_modifiers', 'edit_modifiers', 'delete_modifiers',
            // Settings and system management
            'view_settings', 'edit_settings', 'manage_trash', 'manage_seo', 'view_pulse', 'manage_gtm',
        ];
        $owner->givePermissionTo($ownerPermissions);

        // Human Resources - HR-focused permissions
        $hr = Role::firstOrCreate(['name' => 'Human Resources']);
        $hrPermissions = [
            // Full HR management
            'view_careers', 'create_careers', 'edit_careers', 'view_applications',
            // User management (for employees)
            'view_users', 'create_users', 'edit_users',
            // Contact management (for applicants)
            'view_contacts', 'create_contacts', 'edit_contacts',
            // Limited content for HR materials
            'view_documents', 'create_documents', 'edit_documents',
            'view_media', 'upload_media', 'edit_media',
            // Basic viewing permissions
            'view_categories',
        ];
        $hr->givePermissionTo($hrPermissions);

        // IT - Technical administration
        $it = Role::firstOrCreate(['name' => 'IT']);
        $itPermissions = [
            // User and system management
            'view_users', 'create_users', 'edit_users', 'delete_users', 'assign_roles',
            // System monitoring
            'view_visitors', 'manage_settings', 'view_activity_logs', 'manage_trash', 'view_pulse', 'manage_gtm',
            // Media management (for technical files)
            'view_media', 'upload_media', 'edit_media', 'delete_media',
            // Technical documentation
            'view_documents', 'create_documents', 'edit_documents', 'delete_documents',
            // Limited content access
            'view_blogs', 'view_products', 'view_contacts',
            // Category management for organization
            'view_categories', 'create_categories', 'edit_categories',
        ];
        $it->givePermissionTo($itPermissions);

        // Content Writer - Content creation focused
        $contentWriter = Role::firstOrCreate(['name' => 'Content Writer']);
        $contentWriterPermissions = [
            // Full blog management
            'view_blogs', 'create_blogs', 'edit_blogs', 'publish_blogs',
            // Content management
            'view_documents', 'create_documents', 'edit_documents',
            'view_faqs', 'create_faqs', 'edit_faqs',
            'view_pages', 'create_pages', 'edit_pages', 'publish_pages',
            // Media for content
            'view_media', 'upload_media', 'edit_media',
            // Categories for organization
            'view_categories', 'create_categories', 'edit_categories',
            // SEO management for content
            'manage_seo',
            // Read access for reference
            'view_products', 'view_contacts',
        ];
        $contentWriter->givePermissionTo($contentWriterPermissions);

        // Product Manager - Product-focused permissions
        $productManager = Role::firstOrCreate(['name' => 'Product Manager']);
        $productManagerPermissions = [
            // Full product management
            'view_products', 'create_products', 'edit_products', 'delete_products', 'publish_products',
            'view_product_variants', 'create_product_variants', 'edit_product_variants', 'delete_product_variants',
            // Categories for product organization
            'view_categories', 'create_categories', 'edit_categories', 'delete_categories',
            // Media for products
            'view_media', 'upload_media', 'edit_media',
            // Customer interaction
            'view_quotes', 'create_quotes', 'edit_quotes',
            'view_contacts', 'edit_contacts',
            // Analytics for product performance
            'view_visitors', 'view_reviews',
            // Limited content access
            'view_blogs', 'view_documents', 'view_faqs',
        ];
        $productManager->givePermissionTo($productManagerPermissions);

        // Marketing - Marketing and promotion focused
        $marketing = Role::firstOrCreate(['name' => 'Marketing']);
        $marketingPermissions = [
            // Content marketing
            'view_blogs', 'create_blogs', 'edit_blogs', 'publish_blogs',
            'view_pages', 'create_pages', 'edit_pages', 'publish_pages',
            'view_specials', 'create_specials', 'edit_specials', 'delete_specials',
            'view_videos', 'create_videos', 'edit_videos', 'delete_videos',
            // Product promotion
            'view_products', 'edit_products', 'publish_products',
            'view_product_variants',
            // Media for marketing materials
            'view_media', 'upload_media', 'edit_media',
            // Customer engagement
            'view_contacts', 'create_contacts', 'edit_contacts',
            'view_reviews', 'view_visitors',
            // SEO and marketing optimization
            'manage_seo', 'manage_gtm',
            // Marketing content
            'view_documents', 'create_documents', 'edit_documents',
            'view_service_areas', 'create_service_areas', 'edit_service_areas',
            // Organization
            'view_categories', 'create_categories', 'edit_categories',
            // Limited access
            'view_quotes', 'view_careers', 'view_faqs',
        ];
        $marketing->givePermissionTo($marketingPermissions);

        // Sales - Sales and customer focused
        $sales = Role::firstOrCreate(['name' => 'Sales']);
        $salesPermissions = [
            // Customer management
            'view_contacts', 'create_contacts', 'edit_contacts',
            'view_quotes', 'create_quotes', 'edit_quotes',
            // Product knowledge
            'view_products', 'view_categories',
            // Customer insights
            'view_reviews', 'view_visitors',
            // Sales materials
            'view_documents', 'view_media', 'view_pages',
            // Limited content access
            'view_blogs', 'view_faqs',
        ];
        $sales->givePermissionTo($salesPermissions);
    }

    private function createAdminUser(): void
    {
        // Skip admin creation - handled by UserSeeder
        // This method is kept for role creation only
        $this->command->info('Admin user creation skipped - handled by UserSeeder');
    }
}
