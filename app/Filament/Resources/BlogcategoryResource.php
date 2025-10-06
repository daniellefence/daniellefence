<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\CreateAction;
use App\Filament\Resources\BlogcategoryResource\Pages\ListBlogcategories;
use App\Filament\Resources\BlogcategoryResource\Pages\CreateBlogcategory;
use App\Filament\Resources\BlogcategoryResource\Pages\ViewBlogcategory;
use App\Filament\Resources\BlogcategoryResource\Pages\EditBlogcategory;
use App\Filament\Resources\BlogcategoryResource\Pages;
use App\Filament\Resources\BlogcategoryResource\RelationManagers;
use App\Models\Blogcategory;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogcategoryResource extends Resource
{
    protected static ?string $model = Blogcategory::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-folder';

    protected static string | \UnitEnum | null $navigationGroup = 'Content & Pages';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Blog Category Information')
                    ->description('Manage blog categories for organizing content')
                    ->icon('heroicon-o-folder')
                    ->schema([
                        TextInput::make('title')
                            ->label('Category Title')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., Fence Installation, Maintenance Tips')
                            ->helperText('The display name for this blog category'),
                    ])
                    ->columns(1),

                Section::make('Display Settings')
                    ->description('Control how this category appears on the website')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        TextInput::make('order')
                            ->label('Display Order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Lower numbers appear first in category listings'),

                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Alternative sorting field if needed'),

                        Toggle::make('published')
                            ->label('Published')
                            ->helperText('Show this category on the website')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order')
                    ->label('Order')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->width('80px'),

                TextColumn::make('title')
                    ->label('Category Title')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-o-folder'),

                TextColumn::make('blogs_count')
                    ->label('Blog Posts')
                    ->counts('blogs')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                ToggleColumn::make('published')
                    ->label('Published')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Sort Order')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),

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
            ->defaultSort('order', 'asc')
            ->filters([
                TrashedFilter::make(),
                TernaryFilter::make('published')
                    ->label('Publication Status')
                    ->boolean()
                    ->trueLabel('Published categories')
                    ->falseLabel('Unpublished categories')
                    ->native(false),
            ])
            ->recordActions([
                Action::make('toggle_published')
                    ->label(fn ($record) => $record->published ? 'Unpublish' : 'Publish')
                    ->icon(fn ($record) => $record->published ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn ($record) => $record->published ? 'warning' : 'success')
                    ->action(function ($record) {
                        $record->update(['published' => !$record->published]);
                    })
                    ->requiresConfirmation(),
                ViewAction::make()
                    ->color('info'),
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
            'index' => ListBlogcategories::route('/'),
            'create' => CreateBlogcategory::route('/create'),
            'view' => ViewBlogcategory::route('/{record}'),
            'edit' => EditBlogcategory::route('/{record}/edit'),
        ];
    }
}
