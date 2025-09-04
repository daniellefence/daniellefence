<?php

namespace App\Filament\Resources\PulseResource\Pages;

use App\Filament\Resources\PulseResource;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class PulseDashboard extends Page
{
    protected static string $resource = PulseResource::class;
    protected static string $view = 'filament.pulse.dashboard';

    public function getTitle(): string|Htmlable
    {
        return 'Performance Monitor';
    }

    public function getSubheading(): string
    {
        return 'Real-time application performance monitoring with Laravel Pulse. Monitor slow queries, cache performance, exceptions, and user activity.';
    }
}