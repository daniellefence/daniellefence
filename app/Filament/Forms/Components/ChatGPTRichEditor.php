<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\RichEditor;
use Illuminate\Support\HtmlString;

class ChatGPTRichEditor extends RichEditor
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->extraAttributes(['class' => 'chatgpt-rich-editor']);

        // Add the ChatGPT button as a hint using HtmlString to avoid variable conflicts
        $fieldName = $this->getName();
        $buttonHtml = "
            <div class=\"mb-2\">
                <button
                    type=\"button\"
                    class=\"inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500\"
                    onclick=\"openChatGPTModal('{$fieldName}')\"
                >
                    <svg class=\"w-4 h-4 mr-1.5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">
                        <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M13 10V3L4 14h7v7l9-11h-7z\"/>
                    </svg>
                    Fill with ChatGPT
                </button>
            </div>
        ";

        $this->hint(new HtmlString($buttonHtml));
    }
}