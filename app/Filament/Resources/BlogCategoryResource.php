<?php

namespace App\Filament\Resources;

use App\Models\BlogCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\BlogCategoryResource\Pages;
use Illuminate\Database\Eloquent\Builder;

class BlogCategoryResource extends Resource
{
    protected static ?string $model = BlogCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Blog Categories';
    protected static ?string $pluralLabel = 'Blog Categories';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Category Details')
                ->description('Basic information for organizing blog posts into categories and subcategories.')
                ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null)
                    ->helperText('The display name for this category. This will automatically generate a URL slug.')
                    ->placeholder('e.g., "Technology", "Tutorials", "News"'),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->rules(['alpha_dash'])
                    ->helperText('URL-friendly version of the category name. Only letters, numbers, and dashes allowed.')
                    ->placeholder('auto-generated-from-name'),
                Forms\Components\Select::make('parent_id')
                    ->label('Parent Category')
                    ->relationship('parent', 'name', fn (Builder $query) => $query->rootCategories())
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->helperText('Optional: Select a parent category to create a hierarchy (e.g., "Web Development" under "Technology").'),
                Forms\Components\Toggle::make('published')
                    ->default(true)
                    ->helperText('Enable this to make the category visible on your website. Unpublished categories are hidden from visitors.'),
            ])->columns(2),

            Forms\Components\Section::make('Description')
                ->description('Optional description for this category to help visitors understand its content.')
                ->schema([
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull()
                    ->maxLength(1000)
                    ->helperText('A brief description of what type of blog posts belong in this category (max 1000 characters). This helps with SEO and user navigation.')
                    ->placeholder('Describe what topics and content this category covers...'),
            ]),

            Forms\Components\Section::make('Tags')
                ->description('Associate tags with this category for better organization and discoverability.')
                ->schema([
                Forms\Components\Select::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required()->helperText('Tag name for categorization'),
                    ])
                    ->columnSpanFull()
                    ->helperText('Add relevant tags that relate to this category. These help with content discovery and internal linking.'),
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
                Tables\Columns\TextColumn::make('blogs_count')
                    ->label('Blogs')
                    ->counts('blogs')
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
            'index' => Pages\ListBlogCategories::route('/'),
            'create' => Pages\CreateBlogCategory::route('/create'),
            'view' => Pages\ViewBlogCategory::route('/{record}'),
            'edit' => Pages\EditBlogCategory::route('/{record}/edit'),
        ];
    }
}