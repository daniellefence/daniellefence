<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EditMediaResource extends EditRecord
{
    protected static string $resource = MediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->modalHeading(fn () => "Preview: {$this->record->name}")
                ->modalWidth('5xl')
                ->modalContent(function () {
                    return view('filament.media-preview', [
                        'record' => $this->record,
                        'url' => $this->record->getFullUrl(),
                        'name' => $this->record->name,
                        'collection' => $this->record->collection_name,
                        'size' => MediaResource::formatBytes($this->record->size),
                        'type' => $this->record->mime_type,
                        'alt' => $this->record->getCustomProperty('alt'),
                        'description' => $this->record->getCustomProperty('description'),
                    ]);
                })
                ->modalSubmitAction(false)
                ->modalCancelAction(false),

            Actions\Action::make('download')
                ->label('Download')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn () => $this->record->getFullUrl())
                ->openUrlInNewTab(),

            Actions\ViewAction::make(),

            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Delete Media File')
                ->modalDescription('Are you sure you want to delete this media file? This action cannot be undone and will remove the file from storage.')
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Media file deleted')
                        ->body('The media file has been successfully deleted.')
                ),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Media updated')
            ->body('The media file metadata has been successfully updated.');
    }

    protected function beforeSave(): void
    {
        // Ensure custom_properties is properly formatted as an array
        if (isset($this->data['custom_properties']) && is_string($this->data['custom_properties'])) {
            $this->data['custom_properties'] = json_decode($this->data['custom_properties'], true) ?: [];
        }
    }

    protected function afterSave(): void
    {
        // If the custom properties were updated, make sure they're properly saved
        if (isset($this->data['custom_properties'])) {
            $customProperties = $this->data['custom_properties'];
            
            // Merge with existing properties to avoid overwriting system properties
            $existingProperties = $this->record->custom_properties;
            $mergedProperties = array_merge($existingProperties, $customProperties);
            
            $this->record->update([
                'custom_properties' => $mergedProperties
            ]);
        }
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Ensure custom_properties are properly extracted for the form
        if (isset($data['custom_properties'])) {
            $customProps = $data['custom_properties'];
            
            // Extract specific properties for the form fields
            $data['custom_properties.alt'] = $customProps['alt'] ?? '';
            $data['custom_properties.description'] = $customProps['description'] ?? '';
            $data['custom_properties.caption'] = $customProps['caption'] ?? '';
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Process custom properties before saving
        $customProperties = $this->record->custom_properties ?? [];
        
        // Update specific properties from form
        if (isset($data['custom_properties.alt'])) {
            $customProperties['alt'] = $data['custom_properties.alt'];
            unset($data['custom_properties.alt']);
        }
        
        if (isset($data['custom_properties.description'])) {
            $customProperties['description'] = $data['custom_properties.description'];
            unset($data['custom_properties.description']);
        }
        
        if (isset($data['custom_properties.caption'])) {
            $customProperties['caption'] = $data['custom_properties.caption'];
            unset($data['custom_properties.caption']);
        }

        // Merge with any other custom properties from the KeyValue component
        if (isset($data['custom_properties']) && is_array($data['custom_properties'])) {
            $customProperties = array_merge($customProperties, $data['custom_properties']);
        }

        $data['custom_properties'] = $customProperties;

        return $data;
    }
}