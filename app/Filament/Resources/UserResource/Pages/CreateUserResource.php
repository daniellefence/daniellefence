<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource as Resource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserResource extends CreateRecord
{
    protected static string $resource = Resource::class;
}
