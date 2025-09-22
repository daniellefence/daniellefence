<?php

namespace Tests\Unit\Components;

use App\Filament\Forms\Components\ChatGPTRichEditor;
use Tests\TestCase;

class ChatGPTRichEditorSimpleTest extends TestCase
{
    /** @test */
    public function component_can_be_instantiated()
    {
        $component = new ChatGPTRichEditor('test_field');

        $this->assertInstanceOf(ChatGPTRichEditor::class, $component);
    }

    /** @test */
    public function component_has_make_method()
    {
        $component = ChatGPTRichEditor::make('test_field');

        $this->assertInstanceOf(ChatGPTRichEditor::class, $component);
    }

    /** @test */
    public function component_stores_field_name()
    {
        $component = ChatGPTRichEditor::make('content_field');

        $this->assertEquals('content_field', $component->getName());
    }
}