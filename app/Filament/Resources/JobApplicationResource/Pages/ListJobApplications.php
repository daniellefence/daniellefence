<?php

namespace App\Filament\Resources\JobApplicationResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\JobApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobApplications extends ListRecords
{
    protected static string $resource = JobApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
