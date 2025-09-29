<?php

namespace App\Services;

use App\Setting;
use Carbon\Carbon;

/**
 * Service class for managing Google Analytics integration and configuration.
 *
 * This service handles Google Analytics property ID extraction, service account
 * credential validation, configuration status checking, and provides demo data
 * for development/testing purposes when real analytics data isn't available.
 *
 * @package App\Services
 * @author Shane Barron
 */
class AnalyticsService
{
    /**
     * Setting instance for accessing database configuration.
     *
     * @var \App\Setting
     */
    private $setting;

    /**
     * Create a new AnalyticsService instance.
     */
    public function __construct()
    {
        $this->setting = new Setting();
    }

    /**
     * Extract Google Analytics Property ID from database settings.
     *
     * Searches for a Google Analytics 4 property ID (G-XXXXXXXXXX format)
     * within the analytics code stored in the database.
     *
     * @return string|null The extracted property ID or null if not found
     */
    public function getPropertyId()
    {
        $analyticsCode = $this->setting->get('analytics');

        if (!$analyticsCode) {
            return null;
        }

        // Extract G-XXXXXXXXXX pattern from the analytics code
        if (preg_match('/G-[A-Z0-9]+/', $analyticsCode, $matches)) {
            return $matches[0];
        }

        return null;
    }

    /**
     * Check if Google Analytics is fully configured and ready to use.
     *
     * Validates both the property ID extraction and service account credentials
     * to ensure the analytics integration can function properly.
     *
     * @return bool True if both property ID and credentials are valid
     */
    public function isConfigured()
    {
        $propertyId = $this->getPropertyId();
        $hasCredentials = $this->hasValidCredentials();

        return $propertyId && $hasCredentials;
    }

    /**
     * Validate Google service account credentials from environment variables.
     *
     * Checks for valid service account credentials in the GOOGLE_SERVICE_ACCOUNT_CREDENTIALS
     * environment variable. Validates JSON format and required fields for authentication.
     * Only supports environment-based credentials for security.
     *
     * @return bool True if valid service account credentials are found
     */
    public function hasValidCredentials()
    {
        // Only check for environment credentials - no file support for security
        $credentialsJson = env('GOOGLE_SERVICE_ACCOUNT_CREDENTIALS');

        // Check if credentials are provided and not empty
        if (!$credentialsJson || empty(trim($credentialsJson))) {
            return false;
        }

        // Validate that it's proper JSON format
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

        // Verify it's a service account type
        return $credentials['type'] === 'service_account';
    }

    /**
     * Generate demo analytics data for development and testing.
     *
     * Provides realistic-looking sample data when real Google Analytics
     * data isn't available. Useful for development, testing, and demo environments.
     *
     * @param string $metric The type of metric to generate (pageviews, users, sessions, bounce_rate)
     * @return array Array containing value, change percentage, and 7-day trend data
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
                    'value' => number_format($baseValue * 0.6), // Users typically 60% of pageviews
                    'change' => rand(-5, 15),
                    'trend' => array_map(fn() => rand(30, 120), range(1, 7))
                ];

            case 'sessions':
                return [
                    'value' => number_format($baseValue * 0.8), // Sessions typically 80% of pageviews
                    'change' => rand(-8, 20),
                    'trend' => array_map(fn() => rand(40, 150), range(1, 7))
                ];

            case 'bounce_rate':
                return [
                    'value' => rand(35, 65) . '%', // Realistic bounce rate range
                    'change' => rand(-15, 5), // Lower bounce rate is better
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
     * Get comprehensive analytics configuration status.
     *
     * Provides detailed status information about the Google Analytics setup,
     * including property ID validation, credential checking, and helpful
     * diagnostic messages for troubleshooting.
     *
     * @return array Status array with 'status' (warning|info|success) and 'message'
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
     * Get detailed debug information about credential validation issues.
     *
     * Provides specific diagnostic information about why credential validation
     * failed, helping administrators troubleshoot Google Analytics setup issues.
     *
     * @return string Detailed error message for credential validation failure
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

        // Check for required service account fields
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