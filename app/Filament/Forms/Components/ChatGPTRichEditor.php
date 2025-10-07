<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\RichEditor;
use Illuminate\Support\HtmlString;

class ChatGPTRichEditor extends RichEditor
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->extraInputAttributes([
            'class' => 'chatgpt-enabled-editor',
        ]);

        // Defer the hint setup to avoid accessing uninitialized properties
        $this->dehydrated(fn () => true);

        // Add hint with closure that evaluates after initialization
        $this->hint(function () {
            // Check if component is properly initialized and not disabled
            try {
                if (!isset($this->container) || $this->isDisabled()) {
                    return null;
                }

                $fieldName = $this->getName();
            } catch (\Throwable $e) {
                // If component not fully initialized, don't show button
                return null;
            }

            return new HtmlString('
                <button
                    type="button"
                    onclick="openChatGPTModal(\'' . $fieldName . '\')"
                    class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-white bg-blue-600 border border-transparent rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    AI Generate
                </button>
            ');
        });

        // Use default toolbar buttons from parent
        // Available: attachFiles, blockquote, bold, bulletList, codeBlock, h2, h3, italic, link, orderedList, redo, strike, underline, undo
    }
}
