<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class GoogleTagManagerService
{
    protected string $gtmId;
    protected bool $enabled;

    public function __construct()
    {
        $this->gtmId = $this->getGTMId();
        $this->enabled = $this->isEnabled();
    }

    public function getGTMId(): string
    {
        return Cache::remember('gtm_id', 3600, function () {
            return SiteSetting::get('google_tag_manager_id', '');
        });
    }

    public function isEnabled(): bool
    {
        return Cache::remember('gtm_enabled', 3600, function () {
            return SiteSetting::get('google_tag_manager_enabled', false) && !empty($this->gtmId);
        });
    }

    public function getHeadScript(): string
    {
        if (!$this->enabled) {
            return '';
        }

        return "<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{$this->gtmId}');</script>
<!-- End Google Tag Manager -->";
    }

    public function getBodyScript(): string
    {
        if (!$this->enabled) {
            return '';
        }

        return "<!-- Google Tag Manager (noscript) -->
<noscript><iframe src=\"https://www.googletagmanager.com/ns.html?id={$this->gtmId}\"
height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->";
    }

    public function trackEvent(string $event, array $parameters = []): string
    {
        if (!$this->enabled) {
            return '';
        }

        $dataLayer = json_encode(array_merge([
            'event' => $event
        ], $parameters));

        return "<script>dataLayer.push({$dataLayer});</script>";
    }

    public function trackPageView(string $pageName, array $customData = []): string
    {
        return $this->trackEvent('page_view', array_merge([
            'page_title' => $pageName,
            'page_location' => request()->fullUrl(),
        ], $customData));
    }

    public function trackEcommerce(string $action, array $data = []): string
    {
        $ecommerceData = [
            'event' => 'ecommerce',
            'ecommerce_action' => $action,
        ];

        return $this->trackEvent('ecommerce', array_merge($ecommerceData, $data));
    }

    public function trackFormSubmission(string $formName, array $formData = []): string
    {
        return $this->trackEvent('form_submit', [
            'form_name' => $formName,
            'form_data' => $formData,
        ]);
    }

    public function trackCustomEvent(string $category, string $action, string $label = '', int $value = 0): string
    {
        return $this->trackEvent('custom_event', [
            'event_category' => $category,
            'event_action' => $action,
            'event_label' => $label,
            'value' => $value,
        ]);
    }

    public function getConversionScript(string $conversionId, string $conversionLabel = ''): string
    {
        if (!$this->enabled) {
            return '';
        }

        return $this->trackEvent('conversion', [
            'send_to' => $conversionId . ($conversionLabel ? '/' . $conversionLabel : ''),
        ]);
    }

    public function getDataLayerScript(array $initialData = []): string
    {
        if (!$this->enabled || empty($initialData)) {
            return '';
        }

        $dataLayer = json_encode($initialData);
        return "<script>dataLayer = dataLayer || []; dataLayer.push({$dataLayer});</script>";
    }

    public function generateEnhancedEcommerceScript(string $action, array $ecommerceData): string
    {
        if (!$this->enabled) {
            return '';
        }

        $data = [
            'event' => 'enhanced_ecommerce',
            'ecommerce' => [
                $action => $ecommerceData
            ]
        ];

        $dataLayer = json_encode($data);
        return "<script>dataLayer.push({$dataLayer});</script>";
    }
}