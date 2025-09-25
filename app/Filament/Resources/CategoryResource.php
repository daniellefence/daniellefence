<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    protected static ?string $navigationGroup = 'Products & Catalog';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Category Information')
                    ->description('Manage product categories and their hierarchy')
                    ->icon('heroicon-o-folder-open')
                    ->schema([
                        Forms\Components\Select::make('parent_id')
                            ->label('Parent Category')
                            ->options(Category::whereNull('parent_id')->pluck('title', 'id'))
                            ->placeholder('Select parent category (leave empty for main category)')
                            ->searchable()
                            ->preload()
                            ->helperText('Choose a parent category to create a subcategory'),

                        Forms\Components\TextInput::make('key')
                            ->label('Category Key')
                            ->maxLength(191)
                            ->placeholder('e.g., fencing, gates')
                            ->helperText('Unique identifier for this category (optional)')
                            ->alphaDash(),

                        Forms\Components\TextInput::make('title')
                            ->label('Category Title')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., Residential Fencing, Commercial Gates')
                            ->helperText('The display name for this category'),

                        Forms\Components\RichEditor::make('description')
                            ->label('Category Description')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'link',
                                'bulletList',
                                'orderedList',
                            ])
                            ->placeholder('Describe this category and its products')
                            ->helperText('This description may appear on category pages'),

                        Forms\Components\FileUpload::make('hero_image')
                            ->label('Hero Image')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '21:9',
                                '3:2',
                            ])
                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])
                            ->maxSize(5120) // 5MB max
                            ->directory('categories/hero-images')
                            ->visibility('public')
                            ->columnSpanFull()
                            ->helperText('📐 **Ideal Dimensions:** 1920x1080px (16:9 ratio) or 2560x1080px (21:9 ratio)
📁 **File Format:** JPEG, PNG, or WebP
📦 **File Size:** Maximum 5MB
💡 **Tip:** Use high-quality images for best results on all screen sizes'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Display Settings')
                    ->description('Control how this category appears on the website')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        Forms\Components\TextInput::make('order')
                            ->label('Display Order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Lower numbers appear first in category listings'),

                        Forms\Components\Toggle::make('published')
                            ->label('Published')
                            ->helperText('Show this category on the website')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('Order')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->width('80px'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Category Title')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-o-folder-open')
                    ->description(fn ($record) => $record->key ? "Key: {$record->key}" : null),

                Tables\Columns\TextColumn::make('parent.title')
                    ->label('Parent Category')
                    ->placeholder('Main Category')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('products_count')
                    ->label('Products')
                    ->counts('products')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('children_count')
                    ->label('Subcategories')
                    ->counts('children')
                    ->badge()
                    ->color('warning')
                    ->sortable(),

                Tables\Columns\IconColumn::make('hero_image')
                    ->label('Hero Image')
                    ->boolean()
                    ->trueIcon('heroicon-o-photo')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->sortable()
                    ->getStateUsing(fn ($record) => !empty($record->hero_image)),

                Tables\Columns\ToggleColumn::make('published')
                    ->label('Published')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\TernaryFilter::make('published')
                    ->label('Publication Status')
                    ->boolean()
                    ->trueLabel('Published categories')
                    ->falseLabel('Unpublished categories')
                    ->native(false),
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Parent Category')
                    ->options(Category::whereNull('parent_id')->pluck('title', 'id'))
                    ->placeholder('All categories'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_website')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn ($record) => $record->getRoute(), shouldOpenInNewTab: true)
                    ->visible(fn ($record) => $record->published),
                Tables\Actions\ViewAction::make()
                    ->color('info'),
                Tables\Actions\EditAction::make()
                    ->color('warning'),
                Tables\Actions\DeleteAction::make()
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->update(['published' => true]);
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('unpublish')
                        ->label('Unpublish Selected')
                        ->icon('heroicon-o-eye-slash')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each->update(['published' => false]);
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->recordUrl(fn ($record) => null);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
