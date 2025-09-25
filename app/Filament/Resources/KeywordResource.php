<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeywordResource\Pages;
use App\Filament\Resources\KeywordResource\RelationManagers;
use App\Models\Keyword;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KeywordResource extends Resource
{
    protected static ?string $model = Keyword::class;

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    protected static ?string $navigationGroup = 'Marketing & SEO';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Page Information')
                    ->description('Specify which page these keywords apply to')
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

                Forms\Components\Section::make('SEO Keywords')
                    ->description('Manage keywords for search engine optimization')
                    ->icon('heroicon-o-hashtag')
                    ->schema([
                        Forms\Components\TagsInput::make('keywords')
                            ->label('Keywords')
                            ->placeholder('Add keywords (press Enter after each)')
                            ->helperText('Add relevant keywords for this page. Press Enter after typing each keyword.')
                            ->separator(',')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Keyword Analysis')
                    ->description('Review keyword effectiveness and suggestions')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        Forms\Components\Placeholder::make('keyword_tips')
                            ->label('SEO Tips')
                            ->content(
                                '• Use 5-10 relevant keywords per page<br>' .
                                '• Include location-based keywords (e.g., "Nashville fencing")<br>' .
                                '• Mix short and long-tail keywords<br>' .
                                '• Focus on keywords your customers actually search for<br>' .
                                '• Avoid keyword stuffing'
                            )
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

                Tables\Columns\TagsColumn::make('keywords')
                    ->label('Keywords')
                    ->searchable()
                    ->limit(5)
                    ->separator(',')
                    ->badge(),

                Tables\Columns\TextColumn::make('keyword_count')
                    ->label('Total Keywords')
                    ->state(function ($record) {
                        return count(array_filter(explode(',', $record->keywords ?? '')));
                    })
                    ->badge()
                    ->color(function ($state) {
                        if ($state >= 5 && $state <= 10) {
                            return 'success';
                        } elseif ($state < 5) {
                            return 'warning';
                        } else {
                            return 'danger';
                        }
                    })
                    ->tooltip(function ($state) {
                        if ($state >= 5 && $state <= 10) {
                            return 'Good keyword count';
                        } elseif ($state < 5) {
                            return 'Consider adding more keywords';
                        } else {
                            return 'Too many keywords - may hurt SEO';
                        }
                    }),

                Tables\Columns\IconColumn::make('seo_status')
                    ->label('SEO Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->state(function ($record) {
                        $count = count(array_filter(explode(',', $record->keywords ?? '')));
                        return $count >= 5 && $count <= 10;
                    })
                    ->tooltip(function ($record) {
                        $count = count(array_filter(explode(',', $record->keywords ?? '')));
                        if ($count >= 5 && $count <= 10) {
                            return 'SEO optimized';
                        } elseif ($count < 5) {
                            return 'Add more keywords';
                        } else {
                            return 'Too many keywords';
                        }
                    }),

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
            ->defaultSort('route')
            ->filters([
                Tables\Filters\SelectFilter::make('seo_quality')
                    ->label('SEO Quality')
                    ->options([
                        'good' => 'Good (5-10 keywords)',
                        'needs_work' => 'Needs Work (<5 or >10 keywords)',
                        'no_keywords' => 'No Keywords',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] === 'good',
                            fn (Builder $query): Builder => $query->whereRaw('(CHAR_LENGTH(keywords) - CHAR_LENGTH(REPLACE(keywords, ",", ""))) BETWEEN 4 AND 9')
                        )->when(
                            $data['value'] === 'needs_work',
                            fn (Builder $query): Builder => $query->whereRaw('(CHAR_LENGTH(keywords) - CHAR_LENGTH(REPLACE(keywords, ",", ""))) < 4 OR (CHAR_LENGTH(keywords) - CHAR_LENGTH(REPLACE(keywords, ",", ""))) > 9')
                        )->when(
                            $data['value'] === 'no_keywords',
                            fn (Builder $query): Builder => $query->whereNull('keywords')->orWhere('keywords', '')
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
            'index' => Pages\ListKeywords::route('/'),
            'create' => Pages\CreateKeyword::route('/create'),
            'view' => Pages\ViewKeyword::route('/{record}'),
            'edit' => Pages\EditKeyword::route('/{record}/edit'),
        ];
    }
}
