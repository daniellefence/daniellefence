<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AreasWeServeResource\Pages;
use App\Filament\Resources\AreasWeServeResource\RelationManagers;
use App\Models\AreasWeServe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AreasWeServeResource extends Resource
{
    protected static ?string $model = AreasWeServe::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Content & Pages';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Service Area Information')
                    ->description('Manage the areas where Danielle Fence provides services')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Area Name')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., Lakeland, Tampa, Orlando')
                            ->helperText('Enter the city, neighborhood, or region name'),

                        Forms\Components\TextInput::make('slug')
                            ->label('URL Slug')
                            ->maxLength(191)
                            ->placeholder('auto-generated from title')
                            ->helperText('Used in page URLs (e.g., /fencing-lakeland)')
                            ->disabled(),

                        Forms\Components\TextInput::make('county')
                            ->label('County')
                            ->maxLength(191)
                            ->placeholder('e.g., Polk, Hillsborough, Orange')
                            ->helperText('Florida county name'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('SEO Information')
                    ->description('Search engine optimization settings')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(255)
                            ->placeholder('e.g., Fence Installation in Lakeland, FL | Danielle Fence')
                            ->helperText('Page title for search engines (60 chars recommended)'),

                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(160)
                            ->rows(3)
                            ->placeholder('Professional fence installation services in Lakeland, Florida...')
                            ->helperText('Description for search engines (160 chars recommended)'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Services Content')
                    ->description('Unique content about fencing services in this area')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        \App\Filament\Forms\Components\ChatGPTRichEditor::make('services_content')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Location Details')
                    ->description('Geographic information for map backgrounds')
                    ->icon('heroicon-o-globe-alt')
                    ->schema([
                        Forms\Components\TextInput::make('latitude')
                            ->label('Latitude')
                            ->numeric()
                            ->step(0.00000001)
                            ->placeholder('28.0395')
                            ->helperText('Decimal degrees (auto-populated)'),

                        Forms\Components\TextInput::make('longitude')
                            ->label('Longitude')
                            ->numeric()
                            ->step(0.00000001)
                            ->placeholder('-81.9498')
                            ->helperText('Decimal degrees (auto-populated)'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Display Settings')
                    ->description('Control how this area appears on the website')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        Forms\Components\Toggle::make('published')
                            ->label('Published')
                            ->helperText('Show this area on the website')
                            ->default(true)
                            ->inline(false),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Display Order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Lower numbers appear first. Use 0 for default ordering.'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->width('80px'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Area Name')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-map-pin')
                    ->weight('medium'),

                Tables\Columns\ToggleColumn::make('published')
                    ->label('Published')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable(),

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
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('published')
                    ->label('Publication Status')
                    ->boolean()
                    ->trueLabel('Published areas')
                    ->falseLabel('Unpublished areas')
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
                    ->requiresConfirmation()
                    ->modalDescription(fn ($record) =>
                        $record->published
                            ? 'This will hide the area from the website.'
                            : 'This will make the area visible on the website.'
                    ),
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
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->recordUrl(fn ($record) => null); // Disable row click navigation
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
            'index' => Pages\ListAreasWeServes::route('/'),
            'create' => Pages\CreateAreasWeServe::route('/create'),
            'view' => Pages\ViewAreasWeServe::route('/{record}'),
            'edit' => Pages\EditAreasWeServe::route('/{record}/edit'),
        ];
    }
}
