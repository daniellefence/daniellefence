<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSiteSettings extends ListRecords
{
    protected static string $resource = SiteSettingResource::class;

    public function mount(): void
    {
        parent::mount();
        
        // Automatically ensure required site settings exist when page loads
        SiteSetting::ensureRequiredKeysExist();
    }

    protected function getHeaderActions(): array
    {
        return [
            // Remove create button - settings are managed automatically
        ];
    }
}
