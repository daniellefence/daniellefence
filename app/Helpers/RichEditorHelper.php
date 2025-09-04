<?php

namespace App\Helpers;

use App\Filament\Components\MediaPickerRichEditor;
use Filament\Forms\Components\RichEditor;

class RichEditorHelper
{
    /**
     * Create a standard rich text editor with media integration
     */
    public static function make(string $name): MediaPickerRichEditor
    {
        return MediaPickerRichEditor::make($name)
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
            ])
            ->mediaPickerModalTitle('Select Media from Library')
            ->mediaPickerEmptyStateHeading('No media files found')
            ->mediaPickerEmptyStateDescription('Upload some files to your media library to insert them into your content.');
    }

    /**
     * Create a blog content editor with specific media collection
     */
    public static function makeBlogEditor(string $name): MediaPickerRichEditor
    {
        return static::make($name)
            ->mediaCollection('blog-content')
            ->mediaPickerModalTitle('Select Media for Blog Post')
            ->helperText('Create rich content for your blog post. Use the media button to insert images and files from your library.');
    }

    /**
     * Create a product description editor
     */
    public static function makeProductEditor(string $name): MediaPickerRichEditor
    {
        return static::make($name)
            ->mediaCollection('product-content')
            ->mediaPickerModalTitle('Select Media for Product')
            ->helperText('Describe your product with rich content. Add images and files to enhance the description.');
    }

    /**
     * Create an FAQ answer editor
     */
    public static function makeFaqEditor(string $name): MediaPickerRichEditor
    {
        return static::make($name)
            ->mediaCollection('faq-content')
            ->mediaPickerModalTitle('Select Media for FAQ Answer')
            ->helperText('Provide a detailed answer to the FAQ. You can include images and links to files for more information.');
    }

    /**
     * Create a career description editor
     */
    public static function makeCareerEditor(string $name): MediaPickerRichEditor
    {
        return static::make($name)
            ->mediaCollection('career-content')
            ->mediaPickerModalTitle('Select Media for Career Post')
            ->helperText('Create compelling job descriptions. Add images or documents to showcase your company culture.');
    }

    /**
     * Create a document content editor
     */
    public static function makeDocumentEditor(string $name): MediaPickerRichEditor
    {
        return static::make($name)
            ->mediaCollection('document-content')
            ->mediaPickerModalTitle('Select Media for Document')
            ->helperText('Create rich document content with embedded media from your library.');
    }

    /**
     * Create a page content editor
     */
    public static function makePageEditor(string $name): MediaPickerRichEditor
    {
        return static::make($name)
            ->mediaCollection('page-content')
            ->mediaPickerModalTitle('Select Media for Page')
            ->helperText('Create rich page content. Use the media button to insert images and files from your library.');
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