<?php

namespace App\Filament\Resources;

use App\Models\Attachment;
use App\Models\Contact;
use App\Models\QuoteRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\AttachmentResource\Pages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class AttachmentResource extends Resource
{
    protected static ?string $model = Attachment::class;
    protected static ?string $navigationIcon = 'heroicon-o-paper-clip';
    // protected static ?string $navigationGroup = 'Customer Management';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Attachments';
    protected static ?string $pluralLabel = 'Attachments';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Attachment Details')->schema([
                Forms\Components\MorphToSelect::make('attachable')
                    ->types([
                        Forms\Components\MorphToSelect\Type::make(Contact::class)
                            ->titleAttribute('full_name')
                            ->label('Contact'),
                        Forms\Components\MorphToSelect\Type::make(QuoteRequest::class)
                            ->titleAttribute('id')
                            ->getOptionLabelFromRecordUsing(fn (QuoteRequest $record) => "Quote #{$record->id} - {$record->contact->full_name}")
                            ->label('Quote Request'),
                    ])
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->helperText('The display name for this attachment'),
                Forms\Components\TextInput::make('disk')
                    ->default('public')
                    ->disabled()
                    ->dehydrated()
                    ->helperText('Storage disk where the file is stored'),
            ])->columns(2),

            Forms\Components\Section::make('File Information')->schema([
                Forms\Components\TextInput::make('path')
                    ->required()
                    ->maxLength(500)
                    ->helperText('Full path to the file on disk'),
                Forms\Components\TextInput::make('size')
                    ->numeric()
                    ->suffix('bytes')
                    ->helperText('File size in bytes'),
                Forms\Components\TextInput::make('mime')
                    ->maxLength(100)
                    ->helperText('MIME type of the file (e.g., application/pdf)'),
            ])->columns(3),

            Forms\Components\Section::make('Tags')->schema([
                Forms\Components\Select::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required(),
                    ])
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 40) {
                            return null;
                        }
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('attachable_type')
                    ->label('Attached To')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'App\\Models\\Contact' => 'Contact',
                        'App\\Models\\QuoteRequest' => 'Quote Request',
                        default => class_basename($state),
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'App\\Models\\Contact' => 'info',
                        'App\\Models\\QuoteRequest' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('attachable.display_name')
                    ->label('Related Record')
                    ->getStateUsing(function (Attachment $record) {
                        if ($record->attachable instanceof Contact) {
                            return $record->attachable->full_name;
                        }
                        if ($record->attachable instanceof QuoteRequest) {
                            return "Quote #{$record->attachable->id} - {$record->attachable->contact->full_name}";
                        }
                        return 'N/A';
                    })
                    ->limit(30),
                Tables\Columns\TextColumn::make('file_extension')
                    ->label('Type')
                    ->getStateUsing(fn (Attachment $record) => strtoupper(pathinfo($record->path, PATHINFO_EXTENSION)))
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('size')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return 'Unknown';
                        $units = ['B', 'KB', 'MB', 'GB'];
                        $unitIndex = 0;
                        $size = (int) $state;
                        
                        while ($size >= 1024 && $unitIndex < count($units) - 1) {
                            $size /= 1024;
                            $unitIndex++;
                        }
                        
                        return round($size, 1) . ' ' . $units[$unitIndex];
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('mime')
                    ->label('MIME Type')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('file_exists')
                    ->label('File Exists')
                    ->getStateUsing(fn (Attachment $record) => Storage::disk($record->disk)->exists($record->path))
                    ->boolean(),
                Tables\Columns\TextColumn::make('tags.name')
                    ->badge()
                    ->separator(',')
                    ->limit(3)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('attachable_type')
                    ->label('Attached To')
                    ->options([
                        'App\\Models\\Contact' => 'Contact',
                        'App\\Models\\QuoteRequest' => 'Quote Request',
                    ])
                    ->multiple(),
                Tables\Filters\Filter::make('has_file')
                    ->query(function (Builder $query): Builder {
                        return $query->whereNotNull('path')
                            ->where('path', '!=', '');
                    })
                    ->label('Has File Path'),
                Tables\Filters\Filter::make('file_exists')
                    ->query(function (Builder $query): Builder {
                        return $query->get()->filter(function (Attachment $attachment) {
                            return Storage::disk($attachment->disk)->exists($attachment->path);
                        })->pluck('id')->pipe(function ($ids) use ($query) {
                            return $query->whereIn('id', $ids);
                        });
                    })
                    ->label('File Exists on Disk'),
                Tables\Filters\Filter::make('recent')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subWeek()))
                    ->label('Added This Week'),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Attachment $record) {
                        if (Storage::disk($record->disk)->exists($record->path)) {
                            return Storage::disk($record->disk)->download($record->path, $record->name);
                        }
                    })
                    ->visible(fn (Attachment $record) => Storage::disk($record->disk)->exists($record->path)),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('verify_files')
                        ->label('Verify Files Exist')
                        ->icon('heroicon-o-shield-check')
                        ->action(function ($records) {
                            $existingCount = 0;
                            $missingCount = 0;
                            
                            $records->each(function (Attachment $record) use (&$existingCount, &$missingCount) {
                                if (Storage::disk($record->disk)->exists($record->path)) {
                                    $existingCount++;
                                } else {
                                    $missingCount++;
                                }
                            });
                            
                            \Filament\Notifications\Notification::make()
                                ->title('File Verification Complete')
                                ->body("Found: {$existingCount}, Missing: {$missingCount}")
                                ->color($missingCount > 0 ? 'warning' : 'success')
                                ->send();
                        })
                        ->color('info'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttachmentResource::route('/'),
            'create' => Pages\CreateAttachmentResource::route('/create'),
            'view' => Pages\ViewAttachmentResource::route('/{record}'),
            'edit' => Pages\EditAttachmentResource::route('/{record}/edit'),
        ];
    }
}
