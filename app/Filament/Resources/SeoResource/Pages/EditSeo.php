<?php

namespace App\Filament\Resources\SeoResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\SeoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeo extends EditRecord
{
    protected static string $resource = SeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
