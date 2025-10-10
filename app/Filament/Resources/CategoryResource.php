<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Filament\Forms\Components\ChatGPTRichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\CreateAction;
use App\Filament\Resources\CategoryResource\Pages\ListCategories;
use App\Filament\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Resources\CategoryResource\Pages\ViewCategory;
use App\Filament\Resources\CategoryResource\Pages\EditCategory;
use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-folder-open';

    protected static string | \UnitEnum | null $navigationGroup = 'Products & Catalog';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Category Information')
                    ->description('Manage product categories and their hierarchy')
                    ->icon('heroicon-o-folder-open')
                    ->schema([
                        Select::make('parent_id')
                            ->label('Parent Category')
                            ->options(function ($record) {
                                $query = Category::query();

                                // Exclude the current category to prevent circular reference
                                if ($record) {
                                    $query->where('id', '!=', $record->id);
                                }

                                return $query->orderBy('title')->pluck('title', 'id');
                            })
                            ->placeholder('Select parent category (leave empty for main category)')
                            ->searchable()
                            ->preload()
                            ->helperText('Choose a parent category to create a subcategory'),

                        TextInput::make('title')
                            ->label('Category Title')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., Residential Fencing, Commercial Gates')
                            ->helperText('The display name for this category'),

                        ChatGPTRichEditor::make('description')
                            ->label('Category Description')
                            ->placeholder('Describe this category and its products')
                            ->helperText('This description may appear on category pages'),

                        FileUpload::make('hero_image')
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
                            ->helperText('📐 **Ideal Dimensions:** 1920x1080px (16:9 ratio) or 2560x1080px (21:9 ratio)
📁 **File Format:** JPEG, PNG, or WebP
📦 **File Size:** Maximum 5MB
💡 **Tip:** Use high-quality images for best results on all screen sizes'),
                    ])
                    ->columns(1),

                Section::make('Display Settings')
                    ->description('Control how this category appears on the website')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        Toggle::make('published')
                            ->label('Published')
                            ->helperText('Show this category on the website')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->defaultSort('order', 'asc')
            ->columns([
                TextColumn::make('title')
                    ->label('Category Title')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-o-folder-open')
                    ->description(fn ($record) => $record->key ? "Key: {$record->key}" : null),

                TextColumn::make('parent.title')
                    ->label('Parent Category')
                    ->placeholder('Main Category')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('products_count')
                    ->label('Products')
                    ->counts('products')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('children_count')
                    ->label('Subcategories')
                    ->counts('children')
                    ->badge()
                    ->color('warning')
                    ->sortable(),

                ImageColumn::make('hero_image')
                    ->label('Hero Image')
                    ->disk('public')
                    ->width(80)
                    ->height(50)
                    ->defaultImageUrl(url('/images/no-image.png'))
                    ->sortable(),

                ToggleColumn::make('published')
                    ->label('Published')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                TernaryFilter::make('published')
                    ->label('Publication Status')
                    ->boolean()
                    ->trueLabel('Published categories')
                    ->falseLabel('Unpublished categories')
                    ->native(false),
                SelectFilter::make('parent_id')
                    ->label('Parent Category')
                    ->options(Category::orderBy('title')->pluck('title', 'id'))
                    ->placeholder('All categories'),
            ])
            ->recordActions([
                Action::make('view_website')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn ($record) => $record->getRoute(), shouldOpenInNewTab: true)
                    ->visible(fn ($record) => $record->published),
                EditAction::make()
                    ->color('warning'),
                DeleteAction::make()
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->update(['published' => true]);
                        })
                        ->requiresConfirmation(),
                    BulkAction::make('unpublish')
                        ->label('Unpublish Selected')
                        ->icon('heroicon-o-eye-slash')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each->update(['published' => false]);
                        })
                        ->requiresConfirmation(),
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateAction::make(),
            ]);
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
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'view' => ViewCategory::route('/{record}'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
