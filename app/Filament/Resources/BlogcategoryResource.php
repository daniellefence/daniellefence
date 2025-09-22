<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogcategoryResource\Pages;
use App\Filament\Resources\BlogcategoryResource\RelationManagers;
use App\Models\Blogcategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogcategoryResource extends Resource
{
    protected static ?string $model = Blogcategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Blog Category Information')
                    ->description('Manage blog categories for organizing content')
                    ->icon('heroicon-o-folder')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Category Title')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., Fence Installation, Maintenance Tips')
                            ->helperText('The display name for this blog category'),
                    ])
                    ->columns(1),

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

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Alternative sorting field if needed'),

                        Forms\Components\Toggle::make('published')
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
                    ->icon('heroicon-o-folder'),

                Tables\Columns\TextColumn::make('blogs_count')
                    ->label('Blog Posts')
                    ->counts('blogs')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('published')
                    ->label('Published')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sort Order')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),

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
            ])
            ->actions([
                Tables\Actions\Action::make('toggle_published')
                    ->label(fn ($record) => $record->published ? 'Unpublish' : 'Publish')
                    ->icon(fn ($record) => $record->published ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn ($record) => $record->published ? 'warning' : 'success')
                    ->action(function ($record) {
                        $record->update(['published' => !$record->published]);
                    })
                    ->requiresConfirmation(),
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
            'index' => Pages\ListBlogcategories::route('/'),
            'create' => Pages\CreateBlogcategory::route('/create'),
            'view' => Pages\ViewBlogcategory::route('/{record}'),
            'edit' => Pages\EditBlogcategory::route('/{record}/edit'),
        ];
    }
}
