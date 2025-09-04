<?php

namespace App\Filament\Components;

use Filament\Forms\Components\RichEditor;
use Closure;

class MediaPickerRichEditor extends RichEditor
{
    protected string $view = 'filament.components.media-picker-rich-editor';

    protected bool $enableMediaPicker = true;

    protected ?string $mediaCollection = null;

    protected ?Closure $mediaPickerModalTitle = null;

    protected ?Closure $mediaPickerEmptyStateHeading = null;

    protected ?Closure $mediaPickerEmptyStateDescription = null;

    public static function make(string $name): static
    {
        $static = parent::make($name);
        $static->configure();
        
        return $static;
    }

    public function enableMediaPicker(bool $condition = true): static
    {
        $this->enableMediaPicker = $condition;

        return $this;
    }

    public function disableMediaPicker(): static
    {
        $this->enableMediaPicker = false;

        return $this;
    }

    public function mediaCollection(string $collection): static
    {
        $this->mediaCollection = $collection;

        return $this;
    }

    public function mediaPickerModalTitle(string | Closure $title): static
    {
        $this->mediaPickerModalTitle = $this->evaluate($title) ?: $title;

        return $this;
    }

    public function mediaPickerEmptyStateHeading(string | Closure $heading): static
    {
        $this->mediaPickerEmptyStateHeading = $this->evaluate($heading) ?: $heading;

        return $this;
    }

    public function mediaPickerEmptyStateDescription(string | Closure $description): static
    {
        $this->mediaPickerEmptyStateDescription = $this->evaluate($description) ?: $description;

        return $this;
    }

    public function getMediaPickerModalTitle(): string
    {
        return $this->evaluate($this->mediaPickerModalTitle) ?? 'Select Media';
    }

    public function getMediaPickerEmptyStateHeading(): string
    {
        return $this->evaluate($this->mediaPickerEmptyStateHeading) ?? 'No media found';
    }

    public function getMediaPickerEmptyStateDescription(): string
    {
        return $this->evaluate($this->mediaPickerEmptyStateDescription) ?? 'Upload some media files to your library to get started.';
    }

    public function isMediaPickerEnabled(): bool
    {
        return $this->enableMediaPicker;
    }

    public function getMediaCollection(): ?string
    {
        return $this->mediaCollection;
    }

    public function configure(): static
    {
        $this->toolbarButtons([
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
            'media-picker', // Custom media picker button
        ]);

        return $this;
    }

    public function getExtraAlpineAttributes(): array
    {
        return [
            'x-data' => 'mediaPickerRichEditor({
                mediaCollection: ' . json_encode($this->getMediaCollection()) . ',
                modalTitle: ' . json_encode($this->getMediaPickerModalTitle()) . ',
                emptyStateHeading: ' . json_encode($this->getMediaPickerEmptyStateHeading()) . ',
                emptyStateDescription: ' . json_encode($this->getMediaPickerEmptyStateDescription()) . ',
                isMediaPickerEnabled: ' . json_encode($this->isMediaPickerEnabled()) . ',
            })',
        ];
    }
}