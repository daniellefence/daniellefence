<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource as Resource;
use Filament\Resources\Pages\EditRecord;

class EditUserResource extends EditRecord
{
    protected static string $resource = Resource::class;
}
