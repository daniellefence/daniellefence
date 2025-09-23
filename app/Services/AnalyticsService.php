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
     * Check if we have valid service account credentials from environment variables only
     */
    public function hasValidCredentials()
    {
        // Only check for environment credentials - no file support
        $credentialsJson = env('GOOGLE_SERVICE_ACCOUNT_CREDENTIALS');

        // Check if credentials are provided and not empty
        if (!$credentialsJson || empty(trim($credentialsJson))) {
            return false;
        }

        // Validate that it's proper JSON
        $credentials = json_decode($credentialsJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        // Check for required service account fields
        $requiredFields = ['type', 'project_id', 'private_key', 'client_email'];

        foreach ($requiredFields as $field) {
            if (!isset($credentials[$field]) || empty($credentials[$field])) {
                return false;
            }
        }

        // Verify it's a service account
        return $credentials['type'] === 'service_account';
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
            $debugInfo = $this->getCredentialsDebugInfo();
            return [
                'status' => 'info',
                'message' => "Property ID found ({$propertyId}) but service account credentials issue: {$debugInfo}"
            ];
        }

        return [
            'status' => 'success',
            'message' => "Google Analytics fully configured with property {$propertyId}."
        ];
    }

    /**
     * Get debug information about credentials
     */
    private function getCredentialsDebugInfo()
    {
        $credentialsJson = env('GOOGLE_SERVICE_ACCOUNT_CREDENTIALS');

        if (!$credentialsJson) {
            return 'GOOGLE_SERVICE_ACCOUNT_CREDENTIALS not set in .env file';
        }

        if (empty(trim($credentialsJson))) {
            return 'GOOGLE_SERVICE_ACCOUNT_CREDENTIALS is empty';
        }

        $credentials = json_decode($credentialsJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return 'Invalid JSON format: ' . json_last_error_msg();
        }

        $requiredFields = ['type', 'project_id', 'private_key', 'client_email'];
        $missingFields = [];

        foreach ($requiredFields as $field) {
            if (!isset($credentials[$field]) || empty($credentials[$field])) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            return 'Missing required fields: ' . implode(', ', $missingFields);
        }

        if ($credentials['type'] !== 'service_account') {
            return 'Invalid type: expected "service_account", got "' . ($credentials['type'] ?? 'null') . '"';
        }

        return 'Unknown credentials validation error';
    }
}