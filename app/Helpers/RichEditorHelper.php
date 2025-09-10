<?php

namespace App\Helpers;

use App\Filament\Components\MediaPickerRichEditor;
use Filament\Forms\Components\RichEditor;

class RichEditorHelper
{
    /**
     * Create a standard rich text editor with media integration
     */
    public static function make(string $name): RichEditor
    {
        return RichEditor::make($name)
            ->toolbarButtons([
                'attachFiles',
                'blockquote',
                'bold',
                'bulletList',
                'codeBlock',
                'h2',
                'h3',
                'italic',
                'link',
                'orderedList',
                'redo',
                'strike',
                'underline',
                'undo',
            ]);
    }

    /**
     * Create a blog content editor with specific media collection
     */
    public static function makeBlogEditor(string $name): RichEditor
    {
        return static::make($name)
            ->helperText('Create rich content for your blog post. Use the toolbar buttons to format text and add links.');
    }

    /**
     * Create a product description editor
     */
    public static function makeProductEditor(string $name): RichEditor
    {
        return static::make($name)
            ->helperText('Describe your product with rich content. Use formatting tools to highlight key features.');
    }

    /**
     * Create an FAQ answer editor
     */
    public static function makeFaqEditor(string $name): RichEditor
    {
        return static::make($name)
            ->helperText('Provide a detailed answer to the FAQ. You can format text and add links for more information.');
    }

    /**
     * Create a career description editor
     */
    public static function makeCareerEditor(string $name): RichEditor
    {
        return static::make($name)
            ->helperText('Create compelling job descriptions. Use formatting to highlight requirements and benefits.');
    }

    /**
     * Create a document content editor
     */
    public static function makeDocumentEditor(string $name): RichEditor
    {
        return static::make($name)
            ->helperText('Create rich document content with proper formatting and structure.');
    }

    /**
     * Create a page content editor
     */
    public static function makePageEditor(string $name): RichEditor
    {
        return static::make($name)
            ->helperText('Create rich page content. Use the toolbar to format text and create engaging layouts.');
    }

    /**
     * Create a basic rich text editor without media integration (fallback)
     */
    public static function makeBasic(string $name): RichEditor
    {
        return RichEditor::make($name)
            ->toolbarButtons([
                'attachFiles',
                'blockquote',
                'bold',
                'bulletList',
                'codeBlock',
                'h2',
                'h3',
                'italic',
                'link',
                'orderedList',
                'redo',
                'strike',
                'underline',
                'undo',
            ]);
    }
}