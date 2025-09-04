<?php

namespace App\Filament\Resources;

use App\Models\Document;
use App\Models\DocumentCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\DocumentResource\Pages;
use Illuminate\Database\Eloquent\Builder;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Documents';
    protected static ?string $pluralLabel = 'Documents';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Document Details')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                Forms\Components\Select::make('document_category_id')
                    ->label('Category')
                    ->relationship('category', 'name', fn (Builder $query) => $query->published())
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\TextInput::make('slug')->required(),
                        Forms\Components\Textarea::make('description')->rows(3),
                        Forms\Components\Toggle::make('published')->default(true),
                    ]),
                Forms\Components\Toggle::make('published')
                    ->default(true),
            ])->columns(3),

            Forms\Components\Section::make('Description')->schema([
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull()
                    ->maxLength(1000),
            ]),

            Forms\Components\Section::make('File Upload')->schema([
                Forms\Components\TextInput::make('file_path')
                    ->label('File Path (Legacy)')
                    ->maxLength(500)
                    ->hint('For existing documents with file paths')
                    ->columnSpanFull(),
                FileUpload::make('documents')
                    ->multiple()
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                    ->maxSize(10240)
                    ->maxFiles(10)
                    ->directory('documents')
                    ->disk('public')
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull(),
            ]),

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
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\IconColumn::make('published')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_file')
                    ->label('File')
                    ->getStateUsing(fn ($record) => $record->getFirstMedia('documents') !== null || !empty($record->file_path))
                    ->boolean(),
                Tables\Columns\TextColumn::make('file_extension')
                    ->label('Type')
                    ->getStateUsing(function ($record) {
                        $media = $record->getFirstMedia('documents');
                        if ($media) {
                            return strtoupper(pathinfo($media->file_name, PATHINFO_EXTENSION));
                        }
                        if ($record->file_path) {
                            return strtoupper(pathinfo($record->file_path, PATHINFO_EXTENSION));
                        }
                        return null;
                    })
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('tags.name')
                    ->badge()
                    ->separator(',')
                    ->limit(3)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('document_category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('published')
                    ->label('Published Status')
                    ->trueLabel('Published')
                    ->falseLabel('Draft')
                    ->nullable(),
                Tables\Filters\Filter::make('has_file')
                    ->query(fn (Builder $query): Builder => $query->whereHas('media')->orWhereNotNull('file_path'))
                    ->label('Has File'),
                Tables\Filters\Filter::make('recent')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subWeek()))
                    ->label('Added This Week'),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Document $record) {
                        $media = $record->getFirstMedia('documents');
                        if ($media) {
                            return response()->download($media->getPath(), $media->file_name);
                        }
                        if ($record->file_path && file_exists($record->file_path)) {
                            return response()->download($record->file_path);
                        }
                    })
                    ->visible(fn (Document $record) => $record->getFirstMedia('documents') !== null || (!empty($record->file_path) && file_exists($record->file_path))),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-eye')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['published' => true]);
                            });
                        })
                        ->requiresConfirmation()
                        ->color('success'),
                    Tables\Actions\BulkAction::make('unpublish')
                        ->label('Unpublish Selected')
                        ->icon('heroicon-o-eye-slash')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['published' => false]);
                            });
                        })
                        ->requiresConfirmation()
                        ->color('warning'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'view' => Pages\ViewDocument::route('/{record}'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}