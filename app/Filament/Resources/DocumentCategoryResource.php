<?php

namespace App\Filament\Resources;

use App\Models\DocumentCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\DocumentCategoryResource\Pages;
use Illuminate\Database\Eloquent\Builder;

class DocumentCategoryResource extends Resource
{
    protected static ?string $model = DocumentCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder-open';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Document Categories';
    protected static ?string $pluralLabel = 'Document Categories';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Category Details')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->rules(['alpha_dash']),
                Forms\Components\Select::make('parent_id')
                    ->label('Parent Category')
                    ->relationship('parent', 'name', fn (Builder $query) => $query->rootCategories())
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Forms\Components\Toggle::make('published')
                    ->default(true),
            ])->columns(2),

            Forms\Components\Section::make('Description')->schema([
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull()
                    ->maxLength(1000),
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function ($record, $state) {
                        $prefix = '';
                        if ($record->parent_id) {
                            $prefix = '└─ ';
                        }
                        return $prefix . $state;
                    }),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Parent Category')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('documents_count')
                    ->label('Documents')
                    ->counts('documents')
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\IconColumn::make('published')
                    ->boolean()
                    ->sortable(),
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
                Tables\Filters\TernaryFilter::make('published')
                    ->label('Published Status')
                    ->trueLabel('Published')
                    ->falseLabel('Draft')
                    ->nullable(),
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Parent Category')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('root_categories')
                    ->query(fn (Builder $query): Builder => $query->rootCategories())
                    ->label('Root Categories Only'),
            ])
            ->actions([
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
            ->defaultSort('name', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocumentCategories::route('/'),
            'create' => Pages\CreateDocumentCategory::route('/create'),
            'view' => Pages\ViewDocumentCategory::route('/{record}'),
            'edit' => Pages\EditDocumentCategory::route('/{record}/edit'),
        ];
    }
}