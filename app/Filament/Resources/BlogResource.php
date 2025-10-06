<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Filament\Forms\Components\ChatGPTTiptapEditor;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\BlogResource\Pages\ListBlogs;
use App\Filament\Resources\BlogResource\Pages\CreateBlog;
use App\Filament\Resources\BlogResource\Pages\ViewBlog;
use App\Filament\Resources\BlogResource\Pages\EditBlog;
use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static string | \UnitEnum | null $navigationGroup = 'Content & Pages';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Author')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable(),
                Select::make('blogcategory_id')
                    ->label('Category')
                    ->relationship('blogcategory', 'title')
                    ->required()
                    ->searchable(),
                TextInput::make('title')
                    ->required()
                    ->maxLength(191)
                    ->columnSpanFull(),
                ChatGPTTiptapEditor::make('content')
                    ->required()
                    ->profile('default')
                    ->columnSpanFull(),
                Select::make('tags')
                    ->label('Tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(191),
                    ])
                    ->columnSpanFull(),
                Toggle::make('show_date')
                    ->label('Show publication date')
                    ->default(true),
                Toggle::make('published')
                    ->label('Published')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('blogcategory.title')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                IconColumn::make('show_date')
                    ->boolean(),
                IconColumn::make('published')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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
            'index' => ListBlogs::route('/'),
            'create' => CreateBlog::route('/create'),
            'view' => ViewBlog::route('/{record}'),
            'edit' => EditBlog::route('/{record}/edit'),
        ];
    }
}
