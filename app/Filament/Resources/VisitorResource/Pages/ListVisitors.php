<?php

namespace App\Filament\Resources\VisitorResource\Pages;

use App\Filament\Resources\VisitorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVisitors extends ListRecords
{
    protected static string $resource = VisitorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action - visitors are automatically tracked
        ];
    }

    public function getTitle(): string 
    {
        return 'Website Visitors';
    }

    public function getSubheading(): string
    {
        return 'View analytics data for website visitors including IP addresses, locations, and visit times. Visitor data is automatically collected and cannot be manually created or edited. Use filters to analyze traffic patterns and bulk delete for data cleanup.';
    }
}