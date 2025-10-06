<?php

namespace App\Providers\Filament;

use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use App\Filament\Pages\ActivityDashboard;
use App\Filament\Pages\TrafficAnalytics;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Vite;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName('Danielle Fence Admin')
            ->brandLogo(Vite::asset('resources/images/logo.webp'))
            ->login()
            ->colors([
                'primary' => [
                    50 => '#fef2f2',
                    100 => '#fee2e2',
                    200 => '#fecaca',
                    300 => '#fca5a5',
                    400 => '#f87171',
                    500 => '#8e2a2a',
                    600 => '#dc2626',
                    700 => '#b91c1c',
                    800 => '#991b1b',
                    900 => '#7f1d1d',
                    950 => '#450a0a',
                ],
            ])
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make())
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                ActivityDashboard::class,
                TrafficAnalytics::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->navigationGroups([
                'Dashboard & Analytics',
                'DIY System',
                'Products & Catalog',
                'Content & Pages',
                'Customers & Reviews',
                'Human Resources',
                'Marketing & SEO',
                'System & Users',
            ])
            ->collapsibleNavigationGroups(true)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->renderHook(
                'panels::body.end',
                fn (): string => view('filament.admin-scripts')->render()
            )
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
