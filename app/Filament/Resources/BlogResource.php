<?php

namespace App\Filament\Resources;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\BlogResource\Pages;
use Illuminate\Database\Eloquent\Builder;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Blogs';
    protected static ?string $pluralLabel = 'Blogs';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Blog Details')
                ->description('Essential information for your blog post including title, URL, category, and author.')
                ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null)
                    ->helperText('The main title of your blog post. This will automatically generate a URL slug.')
                    ->placeholder('Enter an engaging blog post title...'),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->rules(['alpha_dash'])
                    ->helperText('URL-friendly version of the title. Only letters, numbers, and dashes allowed.')
                    ->placeholder('auto-generated-from-title'),
                Forms\Components\Select::make('blog_category_id')
                    ->label('Category')
                    ->relationship('category', 'name', fn (Builder $query) => $query->published())
                    ->searchable()
                    ->preload()
                    ->helperText('Choose or create a category to organize your blog posts. Categories help with navigation and SEO.')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required()->helperText('Category display name'),
                        Forms\Components\TextInput::make('slug')->required()->helperText('URL-friendly category identifier'),
                        Forms\Components\Textarea::make('description')->rows(3)->helperText('Brief description of this category'),
                        Forms\Components\Toggle::make('published')->default(true)->helperText('Make this category visible on the website'),
                    ]),
                Forms\Components\Select::make('author_id')
                    ->label('Author')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->default(auth()->id())
                    ->helperText('The person credited as the author of this blog post. Defaults to you.'),
            ])->columns(2),

            Forms\Components\Section::make('Content')
                ->description('The main content of your blog post including excerpt for previews and full rich-text content.')
                ->schema([
                Forms\Components\Textarea::make('excerpt')
                    ->rows(3)
                    ->maxLength(500)
                    ->hint('Brief description of the blog post')
                    ->helperText('A short summary (under 500 characters) that appears in blog listings and social media previews. Think of it as your blog post teaser.')
                    ->placeholder('Write a compelling excerpt that encourages readers to click and read more...')
                    ->columnSpanFull(),
                \App\Helpers\RichEditorHelper::makeBlogEditor('content')
                    ->required()
                    ->columnSpanFull()
                    ->placeholder('Start writing your blog content here...'),
            ]),

            Forms\Components\Section::make('Publishing')
                ->description('Control when and how your blog post is published to the website.')
                ->schema([
                Forms\Components\Toggle::make('published')
                    ->default(false)
                    ->live()
                    ->helperText('Enable this to make the blog post visible on your website. Disabled posts remain as drafts.'),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Publish Date')
                    ->visible(fn (Forms\Get $get) => $get('published'))
                    ->default(now())
                    ->helperText('Set when this post should be published. Future dates will schedule the post for later publication.'),
            ])->columns(2),

            Forms\Components\Section::make('Media & Tags')
                ->description('Visual content and categorization tags to enhance your blog post appeal and searchability.')
                ->schema([
                Forms\Components\FileUpload::make('featured_image')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->maxSize(5120)
                    ->directory('blog/featured')
                    ->helperText('The main image for your blog post (max 5MB). This appears in blog listings and social media shares. Recommended: 16:9 aspect ratio, 1200x675px minimum.'),
                Forms\Components\FileUpload::make('gallery')
                    ->multiple()
                    ->image()
                    ->reorderable()
                    ->maxFiles(10)
                    ->maxSize(5120)
                    ->directory('blog/gallery')
                    ->helperText('Additional images for your blog post gallery (max 10 images, 5MB each). Drag to reorder. These can be referenced in your blog content.'),
                Forms\Components\Select::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required()->helperText('Tag name for categorization'),
                    ])
                    ->columnSpanFull()
                    ->helperText('Add tags to help organize and categorize your blog posts. Tags improve SEO and help visitors find related content.'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->getStateUsing(function ($record): ?string {
                        return $record->getFirstMediaUrl('featured_image');
                    })
                    ->circular()
                    ->size(40),
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
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('published')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
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
                Tables\Filters\SelectFilter::make('blog_category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('author_id')
                    ->label('Author')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('published')
                    ->label('Published Status')
                    ->trueLabel('Published')
                    ->falseLabel('Draft')
                    ->nullable(),
                Tables\Filters\Filter::make('published_this_month')
                    ->query(fn (Builder $query): Builder => $query->whereMonth('published_at', now()->month))
                    ->label('Published This Month'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-eye')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update([
                                    'published' => true,
                                    'published_at' => now(),
                                ]);
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'view' => Pages\ViewBlog::route('/{record}'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view_blogs') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_blogs') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_blogs') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_blogs') ?? false;
    }

    public static function canView($record): bool
    {
        return auth()->user()?->can('view_blogs') ?? false;
    }
}