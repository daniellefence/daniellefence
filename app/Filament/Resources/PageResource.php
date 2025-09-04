<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Pages';
    protected static ?string $pluralLabel = 'Pages';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Page Details')
                ->description('Essential information for your page including title, URL, and author.')
                ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null)
                    ->helperText('The main title of your page. This will automatically generate a URL slug.')
                    ->placeholder('Enter a compelling page title...'),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->rules(['alpha_dash'])
                    ->helperText('URL-friendly version of the title. Only letters, numbers, and dashes allowed.')
                    ->placeholder('auto-generated-from-title'),
                Forms\Components\Select::make('author_id')
                    ->label('Author')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->default(auth()->id())
                    ->helperText('The person credited as the author of this page. Defaults to you.'),
                Forms\Components\Select::make('template')
                    ->options([
                        'default' => 'Default Template',
                        'landing' => 'Landing Page',
                        'about' => 'About Page',
                        'contact' => 'Contact Page',
                        'services' => 'Services Page',
                        'gallery' => 'Gallery Page',
                        'testimonials' => 'Testimonials',
                        'custom' => 'Custom Template',
                    ])
                    ->default('default')
                    ->helperText('Choose the template layout for this page.'),
            ])->columns(2),

            Forms\Components\Section::make('Content')
                ->description('The main content of your page including excerpt for previews and full rich-text content.')
                ->schema([
                Forms\Components\Textarea::make('excerpt')
                    ->rows(3)
                    ->maxLength(500)
                    ->hint('Brief description of the page')
                    ->helperText('A short summary (under 500 characters) that appears in search results and page listings.')
                    ->placeholder('Write a compelling excerpt that describes what visitors will find on this page...')
                    ->columnSpanFull(),
                \App\Helpers\RichEditorHelper::makePageEditor('content')
                    ->required()
                    ->columnSpanFull()
                    ->placeholder('Start writing your page content here...'),
            ]),

            Forms\Components\Section::make('Media Collections')
                ->description('Visual content to enhance your page appeal and functionality.')
                ->schema([
                Forms\Components\FileUpload::make('hero_image')
                    ->label('Hero Image')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '21:9',
                        '3:2',
                    ])
                    ->maxSize(5120)
                    ->directory('pages/hero')
                    ->helperText('The main hero image for your page (max 5MB). This appears prominently at the top. Recommended: 16:9 aspect ratio, 1920x1080px minimum.'),

                Forms\Components\FileUpload::make('thumbnails')
                    ->label('Thumbnail Images')
                    ->multiple()
                    ->image()
                    ->reorderable()
                    ->maxFiles(5)
                    ->maxSize(5120)
                    ->directory('pages/thumbnails')
                    ->helperText('Thumbnail images for previews and cards (max 5 images, 5MB each). Used in listings and social media previews.'),

                Forms\Components\FileUpload::make('gallery')
                    ->label('Image Gallery')
                    ->multiple()
                    ->image()
                    ->reorderable()
                    ->maxFiles(20)
                    ->maxSize(5120)
                    ->directory('pages/gallery')
                    ->helperText('Image gallery for this page (max 20 images, 5MB each). Perfect for showcasing multiple images in a gallery layout.'),
            ])->columns(1),

            Forms\Components\Section::make('Publishing & Settings')
                ->description('Control when and how your page is published to the website.')
                ->schema([
                Forms\Components\Toggle::make('published')
                    ->default(false)
                    ->live()
                    ->helperText('Enable this to make the page visible on your website. Disabled pages remain as drafts.'),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Publish Date')
                    ->visible(fn (Forms\Get $get) => $get('published'))
                    ->default(now())
                    ->helperText('Set when this page should be published. Future dates will schedule the page for later publication.'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Numeric value to control the display order of pages. Lower numbers appear first.'),
                Forms\Components\KeyValue::make('meta_data')
                    ->label('Custom Meta Data')
                    ->helperText('Additional custom data for this page in key-value pairs. Useful for custom templates and integrations.')
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('hero_image')
                    ->getStateUsing(function ($record): ?string {
                        return $record->getFirstMediaUrl('hero');
                    })
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->copyable()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('template')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'default' => 'Default',
                        'landing' => 'Landing',
                        'about' => 'About',
                        'contact' => 'Contact', 
                        'services' => 'Services',
                        'gallery' => 'Gallery',
                        'testimonials' => 'Testimonials',
                        'custom' => 'Custom',
                        default => ucfirst($state),
                    }),
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
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
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
                Tables\Filters\SelectFilter::make('template')
                    ->options([
                        'default' => 'Default Template',
                        'landing' => 'Landing Page',
                        'about' => 'About Page',
                        'contact' => 'Contact Page',
                        'services' => 'Services Page',
                        'gallery' => 'Gallery Page',
                        'testimonials' => 'Testimonials',
                        'custom' => 'Custom Template',
                    ]),
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
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Page $record): string => route('page.show', $record->slug))
                    ->openUrlInNewTab()
                    ->visible(fn (Page $record): bool => $record->published),
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
            ->defaultSort('sort_order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view_pages') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_pages') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_pages') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_pages') ?? false;
    }

    public static function canView($record): bool
    {
        return auth()->user()?->can('view_pages') ?? false;
    }
}
