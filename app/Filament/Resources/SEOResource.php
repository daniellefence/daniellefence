<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SEOResource\Pages;
use App\Models\Blog;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use RalphJSmit\Laravel\SEO\Models\SEO;

class SEOResource extends Resource
{
    protected static ?string $model = SEO::class;
    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';
    protected static ?string $navigationGroup = 'SEO & Marketing';
    protected static ?string $navigationLabel = 'SEO Management';
    protected static ?string $pluralLabel = 'SEO Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('SEO Configuration')
                ->description('Manage SEO settings for pages, products, and blog posts.')
                ->schema([
                Forms\Components\Select::make('model_type')
                    ->label('Content Type')
                    ->options([
                        'App\\Models\\Blog' => 'Blog Posts',
                        'App\\Models\\Product' => 'Products',
                    ])
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(fn (callable $set) => $set('model_id', null))
                    ->helperText('Select the type of content to manage SEO for.'),
                Forms\Components\Select::make('model_id')
                    ->label('Content Item')
                    ->options(function (Forms\Get $get) {
                        $modelType = $get('model_type');
                        if (!$modelType) return [];
                        
                        if ($modelType === 'App\\Models\\Blog') {
                            return Blog::pluck('title', 'id');
                        } elseif ($modelType === 'App\\Models\\Product') {
                            return Product::pluck('name', 'id');
                        }
                        
                        return [];
                    })
                    ->searchable()
                    ->helperText('Select the specific content item to configure SEO for.')
                    ->visible(fn (Forms\Get $get) => filled($get('model_type'))),
            ])->columns(2),

            Forms\Components\Section::make('SEO Meta Data')
                ->description('Configure title, description, and meta tags for search engines.')
                ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('SEO Title')
                    ->maxLength(60)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('title_length', strlen($state ?? ''));
                    })
                    ->helperText('Optimal length: 50-60 characters. This appears as the clickable headline in search results.')
                    ->placeholder('Enter SEO-optimized title...'),
                Forms\Components\Placeholder::make('title_length')
                    ->label('Title Length')
                    ->content(fn ($get) => ($get('title_length') ?? 0) . ' characters')
                    ->visible(fn ($get) => filled($get('title'))),
                Forms\Components\Textarea::make('description')
                    ->label('Meta Description')
                    ->rows(3)
                    ->maxLength(160)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('description_length', strlen($state ?? ''));
                    })
                    ->helperText('Optimal length: 150-160 characters. This appears as the description snippet in search results.')
                    ->placeholder('Write a compelling description that encourages clicks...'),
                Forms\Components\Placeholder::make('description_length')
                    ->label('Description Length')
                    ->content(fn ($get) => ($get('description_length') ?? 0) . ' characters')
                    ->visible(fn ($get) => filled($get('description'))),
            ])->columns(2),

            Forms\Components\Section::make('Advanced SEO')
                ->description('Additional SEO configuration including keywords, robots directives, and social sharing.')
                ->schema([
                Forms\Components\TagsInput::make('keywords')
                    ->label('Focus Keywords')
                    ->helperText('Add relevant keywords for this content. Press Enter after each keyword.')
                    ->placeholder('fence installation, vinyl fencing, etc.')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('author')
                    ->label('Author')
                    ->maxLength(255)
                    ->helperText('Content author for SEO attribution.'),
                Forms\Components\Select::make('robots')
                    ->label('Robots Directive')
                    ->options([
                        'index,follow' => 'Index, Follow (Default)',
                        'noindex,follow' => 'No Index, Follow',
                        'index,nofollow' => 'Index, No Follow',
                        'noindex,nofollow' => 'No Index, No Follow',
                    ])
                    ->default('index,follow')
                    ->helperText('Control how search engines crawl and index this content.'),
            ])->columns(2),

            Forms\Components\Section::make('Open Graph & Social Media')
                ->description('Configure how content appears when shared on social media platforms.')
                ->schema([
                Forms\Components\TextInput::make('og_title')
                    ->label('Social Media Title')
                    ->maxLength(95)
                    ->helperText('Title for social media sharing (Facebook, Twitter, etc.). Leave blank to use SEO title.')
                    ->placeholder('Engaging title for social sharing...'),
                Forms\Components\Textarea::make('og_description')
                    ->label('Social Media Description')
                    ->rows(3)
                    ->maxLength(200)
                    ->helperText('Description for social media sharing. Leave blank to use meta description.')
                    ->placeholder('Compelling description for social media...'),
                Forms\Components\FileUpload::make('og_image')
                    ->label('Social Media Image')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios(['16:9', '1.91:1'])
                    ->maxSize(5120)
                    ->directory('seo/og-images')
                    ->disk('public')
                    ->helperText('Image for social media sharing. Recommended: 1200x630px.')
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Technical SEO')
                ->description('Advanced technical SEO settings for structured data and canonicalization.')
                ->schema([
                Forms\Components\TextInput::make('canonical_url')
                    ->label('Canonical URL')
                    ->url()
                    ->helperText('Canonical URL to prevent duplicate content issues. Leave blank for auto-generation.')
                    ->placeholder('https://example.com/canonical-page'),
                Forms\Components\Select::make('schema_type')
                    ->label('Schema.org Type')
                    ->options([
                        'Article' => 'Article (Blog Posts)',
                        'Product' => 'Product (Products)',
                        'WebPage' => 'Web Page (General Pages)',
                        'Organization' => 'Organization',
                        'LocalBusiness' => 'Local Business',
                        'Service' => 'Service',
                    ])
                    ->helperText('Structured data type for rich snippets in search results.'),
                Forms\Components\KeyValue::make('custom_meta')
                    ->label('Custom Meta Tags')
                    ->keyLabel('Meta Name')
                    ->valueLabel('Content')
                    ->helperText('Additional custom meta tags as needed.')
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('model_type')
                    ->label('Type')
                    ->getStateUsing(function ($record) {
                        if ($record->model_type === 'App\\Models\\Blog') {
                            return 'Blog';
                        } elseif ($record->model_type === 'App\\Models\\Product') {
                            return 'Product';
                        }
                        return 'Unknown';
                    })
                    ->badge()
                    ->color(function (string $state): string {
                        if ($state === 'Blog') return 'success';
                        if ($state === 'Product') return 'warning';
                        return 'gray';
                    }),
                Tables\Columns\TextColumn::make('content_title')
                    ->label('Content')
                    ->getStateUsing(function ($record) {
                        if (!$record->model_type || !$record->model_id) return '—';
                        
                        $model = $record->model_type::find($record->model_id);
                        return $model?->title ?? $model?->name ?? '—';
                    })
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('title')
                    ->label('SEO Title')
                    ->searchable()
                    ->limit(50)
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Meta Description')
                    ->limit(80)
                    ->placeholder('—')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('title_length')
                    ->label('Title Length')
                    ->getStateUsing(fn ($record) => strlen($record->title ?? '') . ' chars')
                    ->color(function ($state) {
                        $length = (int) str_replace(' chars', '', $state);
                        return $length > 60 ? 'danger' : ($length < 30 ? 'warning' : 'success');
                    })
                    ->toggleable(),
                Tables\Columns\TextColumn::make('description_length')
                    ->label('Desc Length')
                    ->getStateUsing(fn ($record) => strlen($record->description ?? '') . ' chars')
                    ->color(function ($state) {
                        $length = (int) str_replace(' chars', '', $state);
                        return $length > 160 ? 'danger' : ($length < 120 ? 'warning' : 'success');
                    })
                    ->toggleable(),
                Tables\Columns\IconColumn::make('has_og_image')
                    ->label('Social Image')
                    ->getStateUsing(fn ($record) => !empty($record->og_image))
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('model_type')
                    ->label('Content Type')
                    ->options([
                        'App\\Models\\Blog' => 'Blog Posts', 
                        'App\\Models\\Product' => 'Products',
                    ]),
                Tables\Filters\Filter::make('missing_title')
                    ->query(fn (Builder $query): Builder => $query->whereNull('title'))
                    ->label('Missing SEO Title'),
                Tables\Filters\Filter::make('missing_description')
                    ->query(fn (Builder $query): Builder => $query->whereNull('description'))
                    ->label('Missing Meta Description'),
                Tables\Filters\Filter::make('title_too_long')
                    ->query(fn (Builder $query): Builder => $query->whereRaw('LENGTH(title) > 60'))
                    ->label('Title Too Long'),
                Tables\Filters\Filter::make('description_too_long')
                    ->query(fn (Builder $query): Builder => $query->whereRaw('LENGTH(description) > 160'))
                    ->label('Description Too Long'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('view_content')
                    ->label('View Content')
                    ->icon('heroicon-o-eye')
                    ->url(function ($record) {
                        if (!$record->model_type || !$record->model_id) return null;
                        
                        $model = $record->model_type::find($record->model_id);
                        if (!$model) return null;
                        
                        if ($record->model_type === 'App\\Models\\Blog') {
                            return route('filament.admin.resources.blogs.edit', $model);
                        } elseif ($record->model_type === 'App\\Models\\Product') {
                            return route('filament.admin.resources.products.edit', $model);
                        }
                        
                        return null;
                    })
                    ->openUrlInNewTab()
                    ->color('info'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('set_robots_noindex')
                        ->label('Set No Index')
                        ->icon('heroicon-o-eye-slash')
                        ->action(fn ($records) => $records->each->update(['robots' => 'noindex,follow']))
                        ->requiresConfirmation()
                        ->color('warning'),
                    Tables\Actions\BulkAction::make('set_robots_index')
                        ->label('Set Index')
                        ->icon('heroicon-o-eye')
                        ->action(fn ($records) => $records->each->update(['robots' => 'index,follow']))
                        ->requiresConfirmation()
                        ->color('success'),
                ]),
            ])
            ->emptyStateHeading('No SEO Data Found')
            ->emptyStateDescription('Create SEO configurations for your pages, blog posts, and products.')
            ->emptyStateIcon('heroicon-o-magnifying-glass')
            ->defaultSort('updated_at', 'desc');
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
            'index' => Pages\ListSEO::route('/'),
            'create' => Pages\CreateSEO::route('/create'),
            'edit' => Pages\EditSEO::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('manage_seo') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('manage_seo') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('manage_seo') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('manage_seo') ?? false;
    }

    public static function canView($record): bool
    {
        return auth()->user()?->can('manage_seo') ?? false;
    }
}