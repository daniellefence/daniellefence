<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GoogleTagManagerResource\Pages;
use App\Models\SiteSetting;
use App\Services\GoogleTagManagerService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;

class GoogleTagManagerResource extends Resource
{
    protected static ?string $model = SiteSetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';
    // protected static ?string $navigationGroup = 'SEO & Marketing';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationLabel = 'Google Tag Manager';
    protected static ?string $pluralLabel = 'Google Tag Manager';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Google Tag Manager Configuration')
                ->description('Configure Google Tag Manager for tracking website analytics, conversions, and user behavior.')
                ->schema([
                Forms\Components\Toggle::make('google_tag_manager_enabled')
                    ->label('Enable Google Tag Manager')
                    ->default(false)
                    ->live()
                    ->helperText('Enable GTM tracking across your website. Make sure you have a valid GTM container ID.'),
                Forms\Components\TextInput::make('google_tag_manager_id')
                    ->label('GTM Container ID')
                    ->placeholder('GTM-XXXXXXX')
                    ->maxLength(20)
                    ->rules(['regex:/^GTM-[A-Z0-9]+$/'])
                    ->helperText('Your Google Tag Manager container ID (format: GTM-XXXXXXX)')
                    ->visible(fn (Forms\Get $get) => $get('google_tag_manager_enabled'))
                    ->required(fn (Forms\Get $get) => $get('google_tag_manager_enabled')),
            ])->columns(2),

            Forms\Components\Section::make('Tracking Configuration')
                ->description('Configure specific tracking features and custom events.')
                ->schema([
                Forms\Components\Toggle::make('gtm_enhanced_ecommerce')
                    ->label('Enhanced Ecommerce Tracking')
                    ->default(true)
                    ->helperText('Enable enhanced ecommerce tracking for detailed product and sales analytics.'),
                Forms\Components\Toggle::make('gtm_form_tracking')
                    ->label('Form Tracking')
                    ->default(true)
                    ->helperText('Automatically track form submissions (contact forms, quote requests, etc.).'),
                Forms\Components\Toggle::make('gtm_scroll_tracking')
                    ->label('Scroll Tracking')
                    ->default(false)
                    ->helperText('Track how far users scroll down pages (25%, 50%, 75%, 100%).'),
                Forms\Components\Toggle::make('gtm_file_download_tracking')
                    ->label('File Download Tracking')
                    ->default(true)
                    ->helperText('Track downloads of PDFs, documents, and other files.'),
                Forms\Components\Toggle::make('gtm_outbound_link_tracking')
                    ->label('Outbound Link Tracking')
                    ->default(true)
                    ->helperText('Track clicks on external links leaving your website.'),
                Forms\Components\Toggle::make('gtm_video_tracking')
                    ->label('Video Tracking')
                    ->default(false)
                    ->helperText('Track YouTube video interactions (play, pause, complete).'),
            ])->columns(2),

            Forms\Components\Section::make('Custom Events & Goals')
                ->description('Define custom tracking events and conversion goals.')
                ->schema([
                Forms\Components\Repeater::make('gtm_custom_events')
                    ->label('Custom Events')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Event Name')
                            ->required()
                            ->placeholder('quote_request_submitted'),
                        Forms\Components\TextInput::make('category')
                            ->label('Category')
                            ->required()
                            ->placeholder('Lead Generation'),
                        Forms\Components\TextInput::make('action')
                            ->label('Action')
                            ->required()
                            ->placeholder('Submit Quote Form'),
                        Forms\Components\TextInput::make('trigger')
                            ->label('Trigger Element')
                            ->placeholder('#quote-form-submit'),
                        Forms\Components\RichEditor::make('description')
                            ->label('Description')
                            ->placeholder('Tracks when users submit quote request forms'),
                    ])
                    ->columns(2)
                    ->defaultItems(0)
                    ->helperText('Define custom events to track specific user interactions on your website.')
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Conversion Tracking')
                ->description('Configure Google Ads conversion tracking and remarketing.')
                ->schema([
                Forms\Components\TextInput::make('google_ads_conversion_id')
                    ->label('Google Ads Conversion ID')
                    ->placeholder('AW-XXXXXXXXX')
                    ->helperText('Your Google Ads conversion tracking ID for measuring campaign performance.'),
                Forms\Components\Repeater::make('conversion_actions')
                    ->label('Conversion Actions')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Conversion Name')
                            ->required()
                            ->placeholder('Quote Request'),
                        Forms\Components\TextInput::make('label')
                            ->label('Conversion Label')
                            ->required()
                            ->placeholder('abcDEF1ghiJKL2'),
                        Forms\Components\TextInput::make('value')
                            ->label('Conversion Value')
                            ->numeric()
                            ->placeholder('25.00')
                            ->helperText('Optional: Set a monetary value for this conversion'),
                        Forms\Components\Select::make('trigger')
                            ->label('Trigger Page/Action')
                            ->options([
                                'contact_form' => 'Contact Form Submission',
                                'quote_request' => 'Quote Request Submission',
                                'phone_call' => 'Phone Number Click',
                                'service_inquiry' => 'Service Inquiry Form',
                                'thank_you_page' => 'Thank You Page View',
                            ])
                            ->searchable(),
                    ])
                    ->columns(2)
                    ->defaultItems(0)
                    ->helperText('Configure specific conversion actions to track in Google Ads.')
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Testing & Debug')
                ->description('Tools for testing and debugging your GTM implementation.')
                ->schema([
                Forms\Components\Toggle::make('gtm_debug_mode')
                    ->label('Debug Mode')
                    ->default(false)
                    ->helperText('Enable debug mode to see GTM events in browser console. Turn off in production.'),
                Forms\Components\Placeholder::make('gtm_preview_link')
                    ->label('GTM Preview Mode')
                    ->content(function () {
                        $gtmId = SiteSetting::get('google_tag_manager_id');
                        if ($gtmId) {
                            return "Open GTM Preview: https://tagmanager.google.com/#/container/accounts/{$gtmId}/containers/{$gtmId}/workspaces";
                        }
                        return 'Configure GTM Container ID to see preview link';
                    })
                    ->helperText('Use this link to preview and debug your GTM setup.'),
                Forms\Components\Actions::make([
                    Forms\Components\Actions\Action::make('test_gtm')
                        ->label('Test GTM Setup')
                        ->action(function () {
                            $gtmService = new GoogleTagManagerService();
                            if ($gtmService->isEnabled()) {
                                return redirect()->back()->with('success', 'GTM is properly configured and enabled!');
                            }
                            return redirect()->back()->with('error', 'GTM configuration is incomplete or disabled.');
                        })
                        ->color('info')
                        ->icon('heroicon-o-beaker'),
                    Forms\Components\Actions\Action::make('clear_cache')
                        ->label('Clear GTM Cache')
                        ->action(function () {
                            Cache::forget('gtm_id');
                            Cache::forget('gtm_enabled');
                            return redirect()->back()->with('success', 'GTM cache cleared successfully!');
                        })
                        ->color('warning')
                        ->icon('heroicon-o-arrow-path'),
                ])
                ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Setting')
                    ->getStateUsing(function ($record) {
                        return match($record->key) {
                            'google_tag_manager_enabled' => 'GTM Enabled',
                            'google_tag_manager_id' => 'Container ID',
                            'gtm_enhanced_ecommerce' => 'Enhanced Ecommerce',
                            'gtm_form_tracking' => 'Form Tracking',
                            'gtm_debug_mode' => 'Debug Mode',
                            default => ucwords(str_replace('_', ' ', $record->key))
                        };
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Value')
                    ->getStateUsing(function ($record) {
                        if (is_bool($record->value)) {
                            return $record->value ? 'Enabled' : 'Disabled';
                        }
                        return $record->value ?: '—';
                    })
                    ->badge()
                    ->color(function ($record) {
                        if (is_bool($record->value)) {
                            return $record->value ? 'success' : 'danger';
                        }
                        return 'gray';
                    }),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('gtm_only')
                    ->query(fn ($query) => $query->where('key', 'like', 'gtm%'))
                    ->label('GTM Settings Only'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->emptyStateHeading('No GTM Settings Found')
            ->emptyStateDescription('Configure Google Tag Manager settings to start tracking website analytics.')
            ->emptyStateIcon('heroicon-o-chart-bar-square');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGoogleTagManager::route('/'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('manage_gtm') ?? false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }
}