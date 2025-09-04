<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;

class ViewMediaResource extends ViewRecord
{
    protected static string $resource = MediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Full Preview')
                ->icon('heroicon-o-magnifying-glass-plus')
                ->modalHeading(fn () => "Full Preview: {$this->record->name}")
                ->modalWidth('7xl')
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
                        'fullPreview' => true,
                    ]);
                })
                ->modalSubmitAction(false)
                ->modalCancelAction(false),

            Actions\Action::make('download')
                ->label('Download')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn () => $this->record->getFullUrl())
                ->openUrlInNewTab(),

            Actions\EditAction::make()
                ->visible(fn () => auth()->user()?->can('update', $this->record)),

            Actions\DeleteAction::make()
                ->visible(fn () => auth()->user()?->can('delete', $this->record))
                ->requiresConfirmation()
                ->modalHeading('Delete Media File')
                ->modalDescription('Are you sure you want to delete this media file? This action cannot be undone and will remove the file from storage.'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Media Preview')
                    ->schema([
                        Infolists\Components\ImageEntry::make('preview')
                            ->hiddenLabel()
                            ->getStateUsing(function () {
                                if (str_starts_with($this->record->mime_type ?? '', 'image/')) {
                                    return $this->record->getFullUrl();
                                }
                                return null;
                            })
                            ->defaultImageUrl(function () {
                                return MediaResource::getFileTypeIcon($this->record->mime_type ?? '');
                            })
                            ->height(300)
                            ->extraAttributes(['class' => 'rounded-lg'])
                            ->visible(fn () => str_starts_with($this->record->mime_type ?? '', 'image/')),

                        Infolists\Components\ViewEntry::make('file_preview')
                            ->hiddenLabel()
                            ->view('filament.media-file-info')
                            ->viewData([
                                'record' => $this->record,
                                'url' => $this->record->getFullUrl(),
                                'type' => MediaResource::getFileType($this->record->mime_type ?? ''),
                                'size' => MediaResource::formatBytes($this->record->size),
                            ])
                            ->visible(fn () => !str_starts_with($this->record->mime_type ?? '', 'image/')),
                    ])
                    ->columnSpanFull(),

                Infolists\Components\Section::make('File Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Media Name')
                            ->weight(FontWeight::SemiBold)
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large),

                        Infolists\Components\TextEntry::make('file_name')
                            ->label('File Name')
                            ->copyable()
                            ->icon('heroicon-m-document'),

                        Infolists\Components\TextEntry::make('collection_name')
                            ->label('Collection')
                            ->badge()
                            ->color('info'),

                        Infolists\Components\TextEntry::make('mime_type')
                            ->label('MIME Type')
                            ->badge()
                            ->color('gray'),

                        Infolists\Components\TextEntry::make('size')
                            ->label('File Size')
                            ->formatStateUsing(fn () => MediaResource::formatBytes($this->record->size))
                            ->icon('heroicon-m-scale'),

                        Infolists\Components\TextEntry::make('disk')
                            ->label('Storage Disk')
                            ->badge()
                            ->color('primary'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Metadata')
                    ->schema([
                        Infolists\Components\TextEntry::make('alt_text')
                            ->label('Alt Text')
                            ->getStateUsing(fn () => $this->record->getCustomProperty('alt'))
                            ->placeholder('No alt text provided')
                            ->icon('heroicon-m-eye'),

                        Infolists\Components\TextEntry::make('description')
                            ->label('Description')
                            ->getStateUsing(fn () => $this->record->getCustomProperty('description'))
                            ->placeholder('No description provided')
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('caption')
                            ->label('Caption')
                            ->getStateUsing(fn () => $this->record->getCustomProperty('caption'))
                            ->placeholder('No caption provided')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Attachment Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('model_info')
                            ->label('Attached To')
                            ->getStateUsing(function () {
                                if (!$this->record->model_type || !$this->record->model_id) {
                                    return 'Unattached';
                                }
                                
                                $modelClass = $this->record->model_type;
                                $modelName = class_basename($modelClass);
                                
                                try {
                                    $model = $modelClass::find($this->record->model_id);
                                    if ($model) {
                                        $title = match ($modelName) {
                                            'Product' => $model->name ?? "Product #{$model->id}",
                                            'Contact' => $model->full_name ?? "Contact #{$model->id}",
                                            'Blog' => $model->title ?? "Blog #{$model->id}",
                                            'User' => $model->name ?? "User #{$model->id}",
                                            default => "{$modelName} #{$model->id}",
                                        };
                                        return "{$modelName}: {$title}";
                                    }
                                } catch (\Exception $e) {
                                    // Model might not exist anymore
                                }
                                
                                return "{$modelName} #{$this->record->model_id} (Missing)";
                            })
                            ->badge()
                            ->color(function () {
                                if (!$this->record->model_type || !$this->record->model_id) {
                                    return 'gray';
                                }
                                
                                try {
                                    $modelClass = $this->record->model_type;
                                    $model = $modelClass::find($this->record->model_id);
                                    return $model ? 'success' : 'danger';
                                } catch (\Exception $e) {
                                    return 'danger';
                                }
                            }),

                        Infolists\Components\TextEntry::make('model_id')
                            ->label('Model ID')
                            ->visible(fn () => $this->record->model_type && $this->record->model_id),
                    ])
                    ->columns(2)
                    ->visible(fn () => $this->record->model_type || $this->record->model_id),

                Infolists\Components\Section::make('Timestamps')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Uploaded At')
                            ->dateTime()
                            ->since()
                            ->icon('heroicon-m-calendar'),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Last Modified')
                            ->dateTime()
                            ->since()
                            ->icon('heroicon-m-pencil'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Infolists\Components\Section::make('Technical Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('uuid')
                            ->label('UUID')
                            ->copyable()
                            ->formatStateUsing(fn () => $this->record->uuid ?: 'Not available'),

                        Infolists\Components\TextEntry::make('order_column')
                            ->label('Order')
                            ->formatStateUsing(fn () => $this->record->order_column ?: 'Not set'),

                        Infolists\Components\TextEntry::make('conversions_disk')
                            ->label('Conversions Disk')
                            ->formatStateUsing(fn () => $this->record->conversions_disk ?: 'Not set'),

                        Infolists\Components\TextEntry::make('generated_conversions')
                            ->label('Generated Conversions')
                            ->formatStateUsing(function () {
                                $conversions = $this->record->generated_conversions;
                                return $conversions ? implode(', ', array_keys($conversions)) : 'None';
                            }),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),

                Infolists\Components\Section::make('Custom Properties')
                    ->schema([
                        Infolists\Components\KeyValueEntry::make('custom_properties')
                            ->hiddenLabel()
                            ->keyLabel('Property')
                            ->valueLabel('Value'),
                    ])
                    ->visible(fn () => !empty($this->record->custom_properties))
                    ->collapsible(),
            ]);
    }
}