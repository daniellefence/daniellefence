<?php

namespace App\Providers;

use Exception;
use Log;
use App\Setting;
use Illuminate\Support\ServiceProvider;
use Spatie\Analytics\Analytics;
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;

class GoogleAnalyticsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Analytics::class, function ($app) {
            // Only proceed if we have valid credentials
            $credentials = $this->getServiceAccountCredentials();
            if (empty($credentials)) {
                // Return null or dummy instance when no credentials
                return new Analytics(new BetaAnalyticsDataClient(), '');
            }

            // Get settings from database
            $setting = new Setting();
            $analyticsCode = $setting->get('analytics');

            // Extract Property ID from the analytics code
            $propertyId = $this->extractPropertyId($analyticsCode);

            if (!$propertyId) {
                // Return a dummy analytics instance if no property ID found
                return new Analytics(new BetaAnalyticsDataClient(), '');
            }

            try {
                // Create analytics client using the property ID from database
                $client = new BetaAnalyticsDataClient([
                    'credentials' => $credentials,
                ]);

                return new Analytics($client, $propertyId);
            } catch (Exception $e) {
                // Log error and return dummy instance
                Log::warning('Google Analytics setup failed: ' . $e->getMessage());
                return new Analytics(new BetaAnalyticsDataClient(), '');
            }
        });
    }

    public function boot()
    {
        // Update the analytics config with database values
        $this->app->booted(function () {
            $setting = new Setting();
            $analyticsCode = $setting->get('analytics');
            $propertyId = $this->extractPropertyId($analyticsCode);

            if ($propertyId) {
                config(['analytics.property_id' => $propertyId]);
            }
        });
    }

    /**
     * Extract Google Analytics Property ID from analytics code
     */
    private function extractPropertyId($analyticsCode)
    {
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
     * Get service account credentials from environment variable only
     */
    private function getServiceAccountCredentials()
    {
        // Only use environment variable - no file support
        $credentialsJson = env('GOOGLE_SERVICE_ACCOUNT_CREDENTIALS');

        // Check if credentials are provided and not empty
        if (!empty($credentialsJson) && trim($credentialsJson) !== '') {
            $credentials = json_decode($credentialsJson, true);

            // Validate JSON and required fields
            if ($credentials &&
                json_last_error() === JSON_ERROR_NONE &&
                isset($credentials['type']) &&
                $credentials['type'] === 'service_account') {
                return $credentials;
            }
        }

        // Return empty array if no valid credentials - widgets will show placeholder data
        return [];
    }
}