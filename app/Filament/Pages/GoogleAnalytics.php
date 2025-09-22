<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

class GoogleAnalytics extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static ?string $navigationGroup = 'Analytics';

    protected static ?int $navigationSort = 2;

    protected static ?string $title = 'Google Analytics';

    protected static string $view = 'filament.pages.google-analytics-enhanced';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'ga_tracking_id' => config('services.google_analytics.tracking_id', ''),
            'ga_measurement_id' => config('services.google_analytics.measurement_id', ''),
            'gtm_container_id' => config('services.google_tag_manager.container_id', ''),
            'analytics_enabled' => config('services.google_analytics.enabled', false),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Google Analytics Configuration')
                    ->description('Configure your Google Analytics and Google Tag Manager settings')
                    ->icon('heroicon-m-chart-bar')
                    ->schema([
                        Toggle::make('analytics_enabled')
                            ->label('Enable Analytics Tracking')
                            ->helperText('Enable or disable Google Analytics tracking site-wide'),

                        TextInput::make('ga_tracking_id')
                            ->label('Google Analytics Tracking ID (GA4)')
                            ->placeholder('G-XXXXXXXXXX')
                            ->helperText('Your Google Analytics 4 Measurement ID'),

                        TextInput::make('gtm_container_id')
                            ->label('Google Tag Manager Container ID')
                            ->placeholder('GTM-XXXXXXX')
                            ->helperText('Your Google Tag Manager container ID'),
                    ])->columns(1),

                Section::make('Analytics Overview')
                    ->description('Quick overview of your analytics setup')
                    ->icon('heroicon-m-eye')
                    ->schema([
                        Placeholder::make('current_status')
                            ->label('Current Status')
                            ->content(fn () => config('services.google_analytics.enabled', false)
                                ? '✅ Analytics tracking is enabled'
                                : '❌ Analytics tracking is disabled'),

                        Placeholder::make('setup_guide')
                            ->label('Setup Instructions')
                            ->content('
                                <div class="space-y-2 text-sm">
                                    <p><strong>1.</strong> Create a Google Analytics 4 property</p>
                                    <p><strong>2.</strong> Copy your Measurement ID (G-XXXXXXXXXX)</p>
                                    <p><strong>3.</strong> Enter the ID above and enable tracking</p>
                                    <p><strong>4.</strong> Optionally set up Google Tag Manager for advanced tracking</p>
                                </div>
                            '),
                    ])->columns(1),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Here you would typically save to your settings system
        // For now, we'll just show a success notification

        Notification::make()
            ->title('Analytics settings saved')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label('Save Settings')
                ->action('save')
                ->color('primary'),
        ];
    }
}
