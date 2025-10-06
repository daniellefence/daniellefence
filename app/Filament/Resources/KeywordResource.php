<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\CreateAction;
use App\Filament\Resources\KeywordResource\Pages\ListKeywords;
use App\Filament\Resources\KeywordResource\Pages\CreateKeyword;
use App\Filament\Resources\KeywordResource\Pages\ViewKeyword;
use App\Filament\Resources\KeywordResource\Pages\EditKeyword;
use App\Filament\Resources\KeywordResource\Pages;
use App\Filament\Resources\KeywordResource\RelationManagers;
use App\Models\Keyword;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KeywordResource extends Resource
{
    protected static ?string $model = Keyword::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-hashtag';

    protected static string | \UnitEnum | null $navigationGroup = 'Marketing & SEO';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Page Information')
                    ->description('Specify which page these keywords apply to')
                    ->icon('heroicon-o-link')
                    ->schema([
                        TextInput::make('route')
                            ->label('Page Route')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., /, /about, /services/fencing')
                            ->helperText('The route or URL path for this page (use "/" for homepage)')
                            ->prefixIcon('heroicon-o-link'),
                    ])
                    ->columns(1),

                Section::make('SEO Keywords')
                    ->description('Manage keywords for search engine optimization')
                    ->icon('heroicon-o-hashtag')
                    ->schema([
                        TagsInput::make('keywords')
                            ->label('Keywords')
                            ->placeholder('Add keywords (press Enter after each)')
                            ->helperText('Add relevant keywords for this page. Press Enter after typing each keyword.')
                            ->separator(',')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Section::make('Keyword Analysis')
                    ->description('Review keyword effectiveness and suggestions')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        Placeholder::make('keyword_tips')
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
                TextColumn::make('route')
                    ->label('Page Route')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-link')
                    ->badge()
                    ->color(fn ($state) => $state === '/' ? 'success' : 'primary')
                    ->weight('medium'),

                TagsColumn::make('keywords')
                    ->label('Keywords')
                    ->searchable()
                    ->limit(5)
                    ->separator(',')
                    ->badge(),

                TextColumn::make('keyword_count')
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

                IconColumn::make('seo_status')
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
            ->defaultSort('route')
            ->filters([
                SelectFilter::make('seo_quality')
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
            ->recordActions([
                Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn ($record) => url($record->route), shouldOpenInNewTab: true),
                ViewAction::make()
                    ->color('info'),
                EditAction::make()
                    ->color('warning'),
                DeleteAction::make()
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListKeywords::route('/'),
            'create' => CreateKeyword::route('/create'),
            'view' => ViewKeyword::route('/{record}'),
            'edit' => EditKeyword::route('/{record}/edit'),
        ];
    }
}
