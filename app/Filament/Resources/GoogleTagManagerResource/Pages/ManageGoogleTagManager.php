<?php

namespace App\Filament\Resources\GoogleTagManagerResource\Pages;

use App\Filament\Resources\GoogleTagManagerResource;
use App\Models\SiteSetting;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;

class ManageGoogleTagManager extends ManageRecords
{
    protected static string $resource = GoogleTagManagerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('reset_settings')
                ->label('Reset GTM Settings')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Reset Google Tag Manager Settings')
                ->modalDescription('This will reset all GTM configuration to default values. This action cannot be undone.')
                ->action(function () {
                    SiteSetting::whereIn('key', [
                        'google_tag_manager_enabled',
                        'google_tag_manager_id',
                        'gtm_enhanced_ecommerce',
                        'gtm_form_tracking',
                        'gtm_scroll_tracking',
                        'gtm_file_download_tracking',
                        'gtm_outbound_link_tracking',
                        'gtm_video_tracking',
                        'gtm_custom_events',
                        'google_ads_conversion_id',
                        'conversion_actions',
                        'gtm_debug_mode'
                    ])->delete();
                    
                    $this->redirect($this->getResource()::getUrl('index'));
                }),
        ];
    }

    public function getTitle(): string
    {
        return 'Google Tag Manager';
    }

    public function getHeading(): string
    {
        return 'Google Tag Manager Configuration';
    }

    public function getSubheading(): ?string
    {
        return 'Configure Google Tag Manager for tracking website analytics, conversions, and user behavior across your fence company website.';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->handleFormData($data);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->handleFormData($data);
    }

    private function handleFormData(array $data): array
    {
        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $this->handleFormData($data);
        
        return new class extends Model {
            protected $table = 'site_settings';
            public $timestamps = false;
        };
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $this->handleFormData($data);
        return $record;
    }

    protected function fillForm(): void
    {
        $settings = SiteSetting::whereIn('key', [
            'google_tag_manager_enabled',
            'google_tag_manager_id',
            'gtm_enhanced_ecommerce',
            'gtm_form_tracking',
            'gtm_scroll_tracking',
            'gtm_file_download_tracking',
            'gtm_outbound_link_tracking',
            'gtm_video_tracking',
            'gtm_custom_events',
            'google_ads_conversion_id',
            'conversion_actions',
            'gtm_debug_mode'
        ])->pluck('value', 'key')->toArray();

        $this->form->fill($settings);
    }
}