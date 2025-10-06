<?php

namespace App\Filament\Forms\Components;

use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Support\HtmlString;

class ChatGPTTiptapEditor extends TiptapEditor
{
    protected function setUp(): void
    {
        parent::setUp();

        // Temporarily disabled to fix infinite loop issue
        // TODO: Re-implement ChatGPT button with proper escaping
    }
}
