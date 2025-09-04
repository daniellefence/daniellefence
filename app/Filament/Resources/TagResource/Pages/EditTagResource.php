<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource as Resource;
use Filament\Resources\Pages\EditRecord;

class EditTagResource extends EditRecord
{
    protected static string $resource = Resource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $locale = app()->getLocale();
        $name = $data['name_localized'] ?? '';
        unset($data['name_localized']);

        // Preserve existing translations; update current locale
        $current = is_array($this->record->name) ? $this->record->name : [$locale => (string) $this->record->name];
        $current[$locale] = $name;
        $data['name'] = $current;

        return $data;
    }
}
