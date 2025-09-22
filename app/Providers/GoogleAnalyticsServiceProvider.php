<?php

namespace App\Providers;

use App\Setting;
use Illuminate\Support\ServiceProvider;
use Spatie\Analytics\Analytics;
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;

class GoogleAnalyticsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Analytics::class, function ($app) {
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
                    'credentials' => $this->getServiceAccountCredentials(),
                ]);

                return new Analytics($client, $propertyId);
            } catch (\Exception $e) {
                // Log error and return dummy instance
                \Log::warning('Google Analytics setup failed: ' . $e->getMessage());
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
     * Get service account credentials - try multiple sources
     */
    private function getServiceAccountCredentials()
    {
        // First try the default location
        $credentialsPath = storage_path('app/analytics/service-account-credentials.json');

        if (file_exists($credentialsPath)) {
            return $credentialsPath;
        }

        // Try environment variable for credentials
        $credentialsJson = env('GOOGLE_APPLICATION_CREDENTIALS_JSON');
        if ($credentialsJson) {
            return json_decode($credentialsJson, true);
        }

        // Try to use default Google Cloud credentials
        $defaultCredentials = env('GOOGLE_APPLICATION_CREDENTIALS');
        if ($defaultCredentials && file_exists($defaultCredentials)) {
            return $defaultCredentials;
        }

        // For now, return empty array - widgets will show placeholder data
        return [];
    }
}