<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeoResource\Pages;
use App\Filament\Resources\SeoResource\RelationManagers;
use App\Models\Seo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SeoResource extends Resource
{
    protected static ?string $model = Seo::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationGroup = 'Marketing & SEO';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Page Information')
                    ->description('Specify which page this SEO configuration applies to')
                    ->icon('heroicon-o-link')
                    ->schema([
                        Forms\Components\TextInput::make('route')
                            ->label('Page Route')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., /, /about, /services/fencing')
                            ->helperText('The route or URL path for this page (use "/" for homepage)')
                            ->prefixIcon('heroicon-o-link'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('SEO Meta Tags')
                    ->description('Configure SEO metadata for search engines')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->placeholder('Page title that appears in search results')
                            ->helperText('Keep under 60 characters for optimal display in search results')
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                $length = strlen($state ?? '');
                                if ($length > 60) {
                                    $set('title_warning', 'Title is too long - may be truncated in search results');
                                } else {
                                    $set('title_warning', null);
                                }
                            })
                            ->suffixActions([
                                Forms\Components\Actions\Action::make('title_count')
                                    ->label(fn ($get) => strlen($get('title') ?? '') . '/60')
                                    ->disabled()
                                    ->color(fn ($get) => strlen($get('title') ?? '') > 60 ? 'danger' : 'success'),
                            ]),

                        Forms\Components\Textarea::make('description')
                            ->label('Meta Description')
                            ->maxLength(160)
                            ->rows(3)
                            ->placeholder('Brief description that appears in search results')
                            ->helperText('Keep under 160 characters for optimal display in search results')
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                $length = strlen($state ?? '');
                                if ($length > 160) {
                                    $set('description_warning', 'Description is too long - may be truncated');
                                } else {
                                    $set('description_warning', null);
                                }
                            })
                            ->columnSpanFull(),

                        Forms\Components\Select::make('tags')
                            ->label('Tags')
                            ->relationship('tags', 'name')
                            ->multiple()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(191),
                            ])
                            ->helperText('Add relevant tags for this page. You can create new tags or select existing ones.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('SEO Preview')
                    ->description('Preview how this page might appear in search results')
                    ->icon('heroicon-o-eye')
                    ->schema([
                        Forms\Components\Placeholder::make('search_preview')
                            ->label('')
                            ->content(function ($get) {
                                $title = $get('title') ?: 'Page Title';
                                $description = $get('description') ?: 'Page description will appear here...';
                                $route = $get('route') ?: '/';

                                return view('filament.seo-preview', [
                                    'title' => $title,
                                    'description' => $description,
                                    'route' => $route,
                                ])->render();
                            })
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('route')
                    ->label('Page Route')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-link')
                    ->badge()
                    ->color(fn ($state) => $state === '/' ? 'success' : 'primary')
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Meta Title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    })
                    ->color(fn ($state) => strlen($state ?? '') > 60 ? 'danger' : 'success')
                    ->description(fn ($record) =>
                        'Length: ' . strlen($record->title ?? '') . '/60 chars'
                    ),

                Tables\Columns\TextColumn::make('description')
                    ->label('Meta Description')
                    ->limit(60)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 60) {
                            return null;
                        }
                        return $state;
                    })
                    ->color(fn ($state) => strlen($state ?? '') > 160 ? 'danger' : 'success')
                    ->description(fn ($record) =>
                        'Length: ' . strlen($record->description ?? '') . '/160 chars'
                    ),

                Tables\Columns\TagsColumn::make('keywords')
                    ->label('Keywords')
                    ->limit(3)
                    ->separator(','),

                Tables\Columns\IconColumn::make('seo_status')
                    ->label('SEO Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->state(function ($record) {
                        return !empty($record->title) &&
                               !empty($record->description) &&
                               strlen($record->title) <= 60 &&
                               strlen($record->description) <= 160;
                    })
                    ->tooltip(function ($record) {
                        if (empty($record->title)) return 'Missing title';
                        if (empty($record->description)) return 'Missing description';
                        if (strlen($record->title) > 60) return 'Title too long';
                        if (strlen($record->description) > 160) return 'Description too long';
                        return 'SEO optimized';
                    }),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('route')
            ->filters([
                Tables\Filters\SelectFilter::make('seo_status')
                    ->label('SEO Status')
                    ->options([
                        'optimized' => 'Optimized',
                        'needs_work' => 'Needs Work',
                        'missing_data' => 'Missing Data',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] === 'optimized',
                            fn (Builder $query): Builder => $query->whereNotNull('title')
                                ->whereNotNull('description')
                                ->whereRaw('LENGTH(title) <= 60')
                                ->whereRaw('LENGTH(description) <= 160')
                        )->when(
                            $data['value'] === 'needs_work',
                            fn (Builder $query): Builder => $query->where(function ($query) {
                                $query->whereRaw('LENGTH(title) > 60')
                                      ->orWhereRaw('LENGTH(description) > 160');
                            })
                        )->when(
                            $data['value'] === 'missing_data',
                            fn (Builder $query): Builder => $query->whereNull('title')
                                ->orWhereNull('description')
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn ($record) => url($record->route), shouldOpenInNewTab: true),
                Tables\Actions\ViewAction::make()
                    ->color('info'),
                Tables\Actions\EditAction::make()
                    ->color('warning'),
                Tables\Actions\DeleteAction::make()
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListSeos::route('/'),
            'create' => Pages\CreateSeo::route('/create'),
            'view' => Pages\ViewSeo::route('/{record}'),
            'edit' => Pages\EditSeo::route('/{record}/edit'),
        ];
    }
}
