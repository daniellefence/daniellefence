<?php

namespace App\Services;

use App\Setting;
use Carbon\Carbon;

class AnalyticsService
{
    private $setting;

    public function __construct()
    {
        $this->setting = new Setting();
    }

    /**
     * Get Google Analytics Property ID from database
     */
    public function getPropertyId()
    {
        $analyticsCode = $this->setting->get('analytics');

        if (!$analyticsCode) {
            return null;
        }

        // Extract G-XXXXXXXXXX from the analytics code
        if (preg_match('/G-[A-Z0-9]+/', $analyticsCode, $matches)) {
            return $matches[0];
        }

        return null;
    }

    /**
     * Check if Google Analytics is properly configured
     */
    public function isConfigured()
    {
        $propertyId = $this->getPropertyId();
        $hasCredentials = $this->hasValidCredentials();

        return $propertyId && $hasCredentials;
    }

    /**
     * Check if we have valid service account credentials
     */
    public function hasValidCredentials()
    {
        // Check for service account JSON file
        $credentialsPath = storage_path('app/analytics/service-account-credentials.json');
        if (file_exists($credentialsPath)) {
            return true;
        }

        // Check for environment credentials
        if (env('GOOGLE_APPLICATION_CREDENTIALS_JSON') || env('GOOGLE_APPLICATION_CREDENTIALS')) {
            return true;
        }

        return false;
    }

    /**
     * Get demo analytics data for display when real data isn't available
     */
    public function getDemoData($metric = 'pageviews')
    {
        $baseValue = rand(1000, 5000);

        switch ($metric) {
            case 'pageviews':
                return [
                    'value' => number_format($baseValue),
                    'change' => rand(-10, 25),
                    'trend' => array_map(fn() => rand(50, 200), range(1, 7))
                ];

            case 'users':
                return [
                    'value' => number_format($baseValue * 0.6),
                    'change' => rand(-5, 15),
                    'trend' => array_map(fn() => rand(30, 120), range(1, 7))
                ];

            case 'sessions':
                return [
                    'value' => number_format($baseValue * 0.8),
                    'change' => rand(-8, 20),
                    'trend' => array_map(fn() => rand(40, 150), range(1, 7))
                ];

            case 'bounce_rate':
                return [
                    'value' => rand(35, 65) . '%',
                    'change' => rand(-15, 5),
                    'trend' => array_map(fn() => rand(30, 70), range(1, 7))
                ];

            default:
                return [
                    'value' => number_format($baseValue),
                    'change' => rand(-10, 20),
                    'trend' => array_map(fn() => rand(20, 100), range(1, 7))
                ];
        }
    }

    /**
     * Get analytics configuration status message
     */
    public function getConfigurationStatus()
    {
        $propertyId = $this->getPropertyId();
        $hasCredentials = $this->hasValidCredentials();

        if (!$propertyId) {
            return [
                'status' => 'warning',
                'message' => 'Google Analytics Property ID not found in database settings.'
            ];
        }

        if (!$hasCredentials) {
            return [
                'status' => 'info',
                'message' => "Property ID found ({$propertyId}) but service account credentials needed for API access."
            ];
        }

        return [
            'status' => 'success',
            'message' => "Google Analytics fully configured with property {$propertyId}."
        ];
    }
}