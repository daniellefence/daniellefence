<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PulseResource\Pages;
use Filament\Resources\Resource;
use Laravel\Pulse\Facades\Pulse;

class PulseResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    // protected static ?string $navigationGroup = 'System Management';
    protected static ?string $navigationLabel = 'Performance Monitor';
    protected static ?string $pluralLabel = 'Performance Monitor';
    protected static ?int $navigationSort = 15;

    public static function getPages(): array
    {
        return [
            'index' => Pages\PulseDashboard::route('/'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view_pulse') ?? false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }
}