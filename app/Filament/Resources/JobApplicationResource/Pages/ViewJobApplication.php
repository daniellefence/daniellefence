<?php

namespace App\Filament\Resources\JobApplicationResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\JobApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewJobApplication extends ViewRecord
{
    protected static string $resource = JobApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
