<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceAreaResource\Pages;
use App\Filament\Resources\ServiceAreaResource\RelationManagers;
use App\Models\ServiceArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceAreaResource extends Resource
{
    protected static ?string $model = ServiceArea::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'Business Settings';
    protected static ?string $navigationLabel = 'Service Areas';
    protected static ?string $pluralLabel = 'Service Areas';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Area Information')
                ->description('Define the geographic areas where you provide services.')
                ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null)
                    ->helperText('Name of the city, town, or area you service.')
                    ->placeholder('Enter area name (e.g., Downtown Austin, Cedar Park)'),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->rules(['alpha_dash'])
                    ->helperText('URL-friendly version of the area name.')
                    ->placeholder('auto-generated-from-name'),
                Forms\Components\TextInput::make('state')
                    ->maxLength(50)
                    ->helperText('State or province where this area is located.')
                    ->placeholder('Texas, California, etc.'),
                Forms\Components\TextInput::make('county')
                    ->maxLength(100)
                    ->helperText('County where this area is located.')
                    ->placeholder('Travis County, Harris County, etc.'),
            ])->columns(2),

            Forms\Components\Section::make('Geographic Details')
                ->description('Optional geographic coordinates and service radius information.')
                ->schema([
                Forms\Components\TextInput::make('latitude')
                    ->numeric()
                    ->step(0.000001)
                    ->helperText('Latitude coordinate for the center of this service area.')
                    ->placeholder('30.2672'),
                Forms\Components\TextInput::make('longitude')
                    ->numeric()
                    ->step(0.000001)
                    ->helperText('Longitude coordinate for the center of this service area.')
                    ->placeholder('-97.7431'),
                Forms\Components\TextInput::make('radius_miles')
                    ->label('Service Radius (Miles)')
                    ->numeric()
                    ->minValue(1)
                    ->helperText('How many miles from the center point do you service? Leave blank for no specific radius.')
                    ->placeholder('25'),
            ])->columns(3),

            Forms\Components\Section::make('Description & Status')
                ->description('Describe this service area and control its visibility.')
                ->schema([
                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->maxLength(1000)
                    ->helperText('Describe the service area, special notes, or coverage details.')
                    ->placeholder('Describe what makes this service area special or any coverage notes...')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_primary')
                    ->label('Primary Service Area')
                    ->default(false)
                    ->helperText('Mark this as one of your main service areas (featured prominently).'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Enable this service area. Inactive areas won\'t be shown on your website.'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower numbers appear first in lists and maps.'),
            ])->columns(2),

            Forms\Components\Section::make('ZIP Codes')
                ->description('Optionally specify specific ZIP codes served in this area.')
                ->schema([
                Forms\Components\TagsInput::make('zip_codes')
                    ->label('ZIP Codes Served')
                    ->helperText('Add specific ZIP codes you service in this area. Press Enter after each ZIP code.')
                    ->placeholder('78701, 78702, 78703...')
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('state')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('county')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_primary')
                    ->label('Primary')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('radius_miles')
                    ->label('Radius')
                    ->suffix(' mi')
                    ->sortable()
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('zip_codes')
                    ->label('ZIP Codes')
                    ->formatStateUsing(function ($state) {
                        if (!$state || !is_array($state)) return '—';
                        return implode(', ', array_slice($state, 0, 3)) . (count($state) > 3 ? '...' : '');
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state')
                    ->searchable(),
                Tables\Filters\TernaryFilter::make('is_primary')
                    ->label('Primary Areas'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
                Tables\Filters\Filter::make('has_coordinates')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('latitude')->whereNotNull('longitude'))
                    ->label('Has Coordinates'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\Action::make('view_on_map')
                    ->label('View on Map')
                    ->icon('heroicon-o-map')
                    ->url(function (ServiceArea $record): ?string {
                        if ($record->latitude && $record->longitude) {
                            return "https://www.google.com/maps?q={$record->latitude},{$record->longitude}";
                        }
                        return "https://www.google.com/maps/search/" . urlencode($record->full_name);
                    })
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => true]);
                            });
                        })
                        ->requiresConfirmation()
                        ->color('success'),
                    Tables\Actions\BulkAction::make('set_primary')
                        ->label('Mark as Primary')
                        ->icon('heroicon-o-star')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_primary' => true]);
                            });
                        })
                        ->requiresConfirmation()
                        ->color('warning'),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceAreas::route('/'),
            'create' => Pages\CreateServiceArea::route('/create'),
            'edit' => Pages\EditServiceArea::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view_service_areas') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_service_areas') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_service_areas') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_service_areas') ?? false;
    }

    public static function canView($record): bool
    {
        return auth()->user()?->can('view_service_areas') ?? false;
    }
}
