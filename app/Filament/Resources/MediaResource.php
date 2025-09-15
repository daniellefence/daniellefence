<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Forms;
use Filament\Forms\Form;
use App\Filament\Resources\MediaResource\Pages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Support\Enums\FontWeight;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    // protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 11;
    protected static ?string $navigationLabel = 'Media Library';
    protected static ?string $modelLabel = 'Media File';
    protected static ?string $pluralModelLabel = 'Media Files';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Media Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Media Name/Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        
                        Forms\Components\TextInput::make('file_name')
                            ->label('File Name')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpan(1),
                        
                        Forms\Components\TextInput::make('collection_name')
                            ->label('Collection')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Accessibility & SEO')
                    ->schema([
                        Forms\Components\TextInput::make('custom_properties.alt')
                            ->label('Alt Text')
                            ->helperText('Describe the image for screen readers and SEO')
                            ->maxLength(255),
                        
                        Forms\Components\RichEditor::make('custom_properties.description')
                            ->label('Description/Caption')
                            ->helperText('Detailed description or caption for the media'),
                        
                        Forms\Components\RichEditor::make('custom_properties.caption')
                            ->label('Caption')
                            ->helperText('Short caption to display with the media'),
                    ]),
                
                Forms\Components\Section::make('File Details')
                    ->schema([
                        Forms\Components\TextInput::make('mime_type')
                            ->label('MIME Type')
                            ->disabled()
                            ->dehydrated(false),
                        
                        Forms\Components\TextInput::make('size')
                            ->label('File Size')
                            ->disabled()
                            ->dehydrated(false)
                            ->formatStateUsing(fn (?int $state): string => $state ? static::formatBytes($state) : 'Unknown'),
                        
                        Forms\Components\TextInput::make('disk')
                            ->label('Storage Disk')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(3)
                    ->collapsible(),
                
                Forms\Components\Section::make('Custom Properties')
                    ->schema([
                        Forms\Components\KeyValue::make('custom_properties')
                            ->label('Additional Properties')
                            ->helperText('Add custom metadata as key-value pairs')
                            ->keyLabel('Property Name')
                            ->valueLabel('Property Value')
                            ->reorderable()
                            ->addActionLabel('Add Property'),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('preview')
                        ->getStateUsing(function (Media $record) {
                            if (str_starts_with($record->mime_type ?? '', 'image/')) {
                                return $record->getFullUrl();
                            }
                            return null;
                        })
                        ->defaultImageUrl(function (Media $record) {
                            return static::getFileTypeIcon($record->mime_type ?? '');
                        })
                        ->size(80)
                        ->square(),
                    
                    Tables\Columns\TextColumn::make('name')
                        ->searchable()
                        ->sortable()
                        ->weight(FontWeight::Medium)
                        ->wrap(),
                        
                    Tables\Columns\TextColumn::make('file_name')
                        ->color('gray')
                        ->size(Tables\Columns\TextColumn\TextColumnSize::Small),
                ])->space(2),

                Tables\Columns\TextColumn::make('collection_name')
                    ->label('Collection')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('file_type')
                    ->label('Type')
                    ->getStateUsing(fn (Media $record) => static::getFileType($record->mime_type ?? ''))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Image' => 'success',
                        'Video' => 'warning',
                        'Document' => 'info',
                        'Audio' => 'purple',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('size')
                    ->label('Size')
                    ->formatStateUsing(fn (?int $state): string => $state ? static::formatBytes($state) : 'Unknown')
                    ->sortable(),

                Tables\Columns\TextColumn::make('model_relation')
                    ->label('Attached To')
                    ->getStateUsing(function (Media $record) {
                        if (!$record->model_type || !$record->model_id) {
                            return 'Unattached';
                        }
                        
                        $modelClass = $record->model_type;
                        $modelName = class_basename($modelClass);
                        
                        try {
                            $model = $modelClass::find($record->model_id);
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
                        
                        return "{$modelName} #{$record->model_id} (Missing)";
                    })
                    ->color(fn (string $state): string => str_contains($state, 'Missing') ? 'danger' : 'primary')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where('model_type', 'like', "%{$search}%");
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('dimensions')
                    ->label('Dimensions')
                    ->getStateUsing(function (Media $record) {
                        $properties = $record->custom_properties;
                        if (isset($properties['width']) && isset($properties['height'])) {
                            return "{$properties['width']} × {$properties['height']}";
                        }
                        return null;
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('collection_name')
                    ->options(fn () => Media::query()
                        ->select('collection_name')
                        ->distinct()
                        ->pluck('collection_name', 'collection_name')
                        ->filter()
                        ->all()
                    )
                    ->label('Collection')
                    ->multiple(),

                SelectFilter::make('file_type')
                    ->options([
                        'image' => 'Images',
                        'video' => 'Videos',
                        'audio' => 'Audio',
                        'document' => 'Documents',
                        'archive' => 'Archives',
                        'other' => 'Other',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['values'])) {
                            return $query;
                        }

                        return $query->where(function (Builder $query) use ($data) {
                            foreach ($data['values'] as $type) {
                                $query->orWhere('mime_type', 'like', "{$type}/%");
                            }
                        });
                    })
                    ->multiple(),

                SelectFilter::make('model_type')
                    ->options(fn () => Media::query()
                        ->whereNotNull('model_type')
                        ->select('model_type')
                        ->distinct()
                        ->get()
                        ->pluck('model_type')
                        ->mapWithKeys(fn ($type) => [$type => class_basename($type)])
                        ->all()
                    )
                    ->label('Attached To Model')
                    ->multiple(),

                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Uploaded From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Uploaded Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = Indicator::make('Uploaded from ' . Carbon::parse($data['created_from'])->toFormattedDateString())
                                ->removeField('created_from');
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = Indicator::make('Uploaded until ' . Carbon::parse($data['created_until'])->toFormattedDateString())
                                ->removeField('created_until');
                        }
                        return $indicators;
                    }),

                Filter::make('size')
                    ->form([
                        Forms\Components\Select::make('size_range')
                            ->options([
                                'small' => 'Small (< 1MB)',
                                'medium' => 'Medium (1MB - 10MB)',
                                'large' => 'Large (10MB - 100MB)',
                                'xlarge' => 'Very Large (> 100MB)',
                            ])
                            ->label('File Size Range'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!($data['size_range'] ?? null)) {
                            return $query;
                        }

                        return match ($data['size_range']) {
                            'small' => $query->where('size', '<', 1024 * 1024),
                            'medium' => $query->whereBetween('size', [1024 * 1024, 10 * 1024 * 1024]),
                            'large' => $query->whereBetween('size', [10 * 1024 * 1024, 100 * 1024 * 1024]),
                            'xlarge' => $query->where('size', '>', 100 * 1024 * 1024),
                            default => $query,
                        };
                    })
                    ->indicateUsing(function (array $data): ?Indicator {
                        if (!($data['size_range'] ?? null)) {
                            return null;
                        }

                        $labels = [
                            'small' => 'Small files (< 1MB)',
                            'medium' => 'Medium files (1MB - 10MB)',
                            'large' => 'Large files (10MB - 100MB)',
                            'xlarge' => 'Very large files (> 100MB)',
                        ];

                        return Indicator::make($labels[$data['size_range']])
                            ->removeField('size_range');
                    }),

                Filter::make('unattached')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->whereNull('model_type'))
                    ->label('Show only unattached files'),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->filtersFormColumns(2)
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalWidth('5xl'),

                Action::make('preview')
                    ->icon('heroicon-o-eye')
                    ->modalHeading(fn (Media $record) => "Preview: {$record->name}")
                    ->modalWidth('5xl')
                    ->modalContent(function (Media $record) {
                        return view('filament.media-preview', [
                            'record' => $record,
                            'url' => $record->getFullUrl(),
                            'name' => $record->name,
                            'collection' => $record->collection_name,
                            'size' => static::formatBytes($record->size),
                            'type' => $record->mime_type,
                            'alt' => $record->getCustomProperty('alt'),
                            'description' => $record->getCustomProperty('description'),
                        ]);
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false),

                Action::make('download')
                    ->url(fn (Media $record) => $record->getFullUrl())
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-arrow-down-tray')
                    ->label('Download'),

                Tables\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()?->can('update', Media::class)),

                Action::make('attach')
                    ->label('Attach to...')
                    ->icon('heroicon-o-link')
                    ->form([
                        Forms\Components\MorphToSelect::make('attachable')
                            ->types([
                                Forms\Components\MorphToSelect\Type::make(\App\Models\Product::class)->titleAttribute('name'),
                                Forms\Components\MorphToSelect\Type::make(\App\Models\Contact::class)->titleAttribute('full_name'),
                                Forms\Components\MorphToSelect\Type::make(\App\Models\QuoteRequest::class)->titleAttribute('id'),
                                Forms\Components\MorphToSelect\Type::make(\App\Models\Blog::class)->titleAttribute('title'),
                                Forms\Components\MorphToSelect\Type::make(\App\Models\User::class)->titleAttribute('name'),
                            ])
                            ->required(),
                    ])
                    ->action(function (Media $record, array $data) {
                        $attach = $data['attachable'];
                        $record->update([
                            'model_type' => $attach::class,
                            'model_id' => $attach->getKey(),
                        ]);
                    })
                    ->visible(fn (Media $record) => 
                        auth()->user()?->can('update', $record) && 
                        (!$record->model_type || !$record->model_id)
                    ),

                Action::make('detach')
                    ->label('Detach')
                    ->icon('heroicon-o-x-mark')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function (Media $record) {
                        $record->update([
                            'model_type' => null,
                            'model_id' => null,
                        ]);
                    })
                    ->visible(fn (Media $record) => 
                        auth()->user()?->can('update', $record) && 
                        $record->model_type && $record->model_id
                    ),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn (Media $record) => auth()->user()?->can('delete', $record)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('organize')
                        ->label('Move to Collection')
                        ->icon('heroicon-o-folder')
                        ->form([
                            Forms\Components\TextInput::make('collection_name')
                                ->label('Collection Name')
                                ->required()
                                ->datalist(fn () => Media::query()
                                    ->select('collection_name')
                                    ->distinct()
                                    ->pluck('collection_name')
                                    ->filter()
                                    ->values()
                                    ->all()
                                ),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $records->each(function (Media $record) use ($data) {
                                $record->move($record->model, $data['collection_name']);
                            });
                        })
                        ->deselectRecordsAfterCompletion()
                        ->visible(fn () => auth()->user()?->can('update', Media::class)),

                    BulkAction::make('detach_all')
                        ->label('Detach All')
                        ->icon('heroicon-o-x-mark')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $records->each(function (Media $record) {
                                $record->update([
                                    'model_type' => null,
                                    'model_id' => null,
                                ]);
                            });
                        })
                        ->deselectRecordsAfterCompletion()
                        ->visible(fn () => auth()->user()?->can('update', Media::class)),

                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->can('delete', Media::class)),
                ]),
            ])
            ->emptyStateHeading('No media files found')
            ->emptyStateDescription('Upload some files to get started with your media library.')
            ->emptyStateIcon('heroicon-o-photo')
            ->defaultSort('created_at', 'desc')
            ->searchable()
            ->persistSearchInSession()
            ->persistFiltersInSession()
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMediaResource::route('/'),
            'create' => Pages\CreateMediaResource::route('/create'),
            'view' => Pages\ViewMediaResource::route('/{record}'),
            'edit' => Pages\EditMediaResource::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 100 ? 'warning' : 'primary';
    }

    public static function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    public static function getFileType(string $mimeType): string
    {
        return match (true) {
            str_starts_with($mimeType, 'image/') => 'Image',
            str_starts_with($mimeType, 'video/') => 'Video',
            str_starts_with($mimeType, 'audio/') => 'Audio',
            in_array($mimeType, [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'text/plain',
                'text/csv',
            ]) => 'Document',
            in_array($mimeType, [
                'application/zip',
                'application/x-rar-compressed',
                'application/x-tar',
                'application/gzip',
            ]) => 'Archive',
            default => 'Other',
        };
    }

    public static function getFileTypeIcon(string $mimeType): string
    {
        $type = static::getFileType($mimeType);
        
        return match ($type) {
            'Image' => '/images/icons/image-file.svg',
            'Video' => '/images/icons/video-file.svg',
            'Audio' => '/images/icons/audio-file.svg',
            'Document' => '/images/icons/document-file.svg',
            'Archive' => '/images/icons/archive-file.svg',
            default => '/images/icons/generic-file.svg',
        };
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view_media') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('upload_media') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_media') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_media') ?? false;
    }

    public static function canView($record): bool
    {
        return auth()->user()?->can('view_media') ?? false;
    }
}