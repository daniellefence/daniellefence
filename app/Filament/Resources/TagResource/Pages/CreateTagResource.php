<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource as Resource;
use Filament\Resources\Pages\CreateRecord;

class CreateTagResource extends CreateRecord
{
    protected static string $resource = Resource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $locale = app()->getLocale();
        $name = $data['name_localized'] ?? '';
        unset($data['name_localized']);
        $data['name'] = [$locale => $name];

        return $data;
    }
}
