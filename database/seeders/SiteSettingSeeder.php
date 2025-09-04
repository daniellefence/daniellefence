<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // SEO Settings
            [
                'key' => 'site_title',
                'value' => 'Daniel\'s Fence Company',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'Default Site Title',
                'description' => 'The default title for your website. Used when no specific page title is set.',
                'is_public' => true,
                'sort_order' => 1,
            ],
            [
                'key' => 'site_description',
                'value' => 'Professional fence installation and repair services. Quality craftsmanship and reliable service for residential and commercial properties.',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'Default Site Description',
                'description' => 'The default meta description for your website. Keep it under 160 characters.',
                'is_public' => true,
                'sort_order' => 2,
            ],
            [
                'key' => 'site_keywords',
                'value' => 'fence installation, fence repair, residential fencing, commercial fencing, fence contractor',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'Default Site Keywords',
                'description' => 'Default meta keywords for your website. Separate with commas.',
                'is_public' => true,
                'sort_order' => 3,
            ],

            // Company Information
            [
                'key' => 'company_name',
                'value' => 'Daniel\'s Fence Company',
                'type' => 'text',
                'group' => 'company',
                'label' => 'Company Name',
                'description' => 'Your official company name.',
                'is_public' => true,
                'sort_order' => 1,
            ],
            [
                'key' => 'company_phone',
                'value' => '(555) 123-4567',
                'type' => 'text',
                'group' => 'company',
                'label' => 'Company Phone',
                'description' => 'Main phone number for your business.',
                'is_public' => true,
                'sort_order' => 2,
            ],
            [
                'key' => 'company_email',
                'value' => 'info@danielsfence.com',
                'type' => 'text',
                'group' => 'company',
                'label' => 'Company Email',
                'description' => 'Main email address for your business.',
                'is_public' => true,
                'sort_order' => 3,
            ],

            // Analytics & Tracking
            [
                'key' => 'google_tag_manager_id',
                'value' => '',
                'type' => 'text',
                'group' => 'analytics',
                'label' => 'Google Tag Manager ID',
                'description' => 'Your Google Tag Manager container ID (e.g., GTM-XXXXXXX).',
                'is_public' => false,
                'sort_order' => 1,
            ],
            [
                'key' => 'youtube_api_key',
                'value' => '',
                'type' => 'text',
                'group' => 'social',
                'label' => 'YouTube API Key',
                'description' => 'YouTube Data API key for fetching videos automatically.',
                'is_public' => false,
                'sort_order' => 1,
            ],
        ];

        foreach ($settings as $setting) {
            \App\Models\SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
