<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use App\Filament\Forms\Components\ChatGPTRichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\CreateAction;
use App\Filament\Resources\AreasWeServeResource\Pages\ListAreasWeServes;
use App\Filament\Resources\AreasWeServeResource\Pages\CreateAreasWeServe;
use App\Filament\Resources\AreasWeServeResource\Pages\ViewAreasWeServe;
use App\Filament\Resources\AreasWeServeResource\Pages\EditAreasWeServe;
use App\Filament\Resources\AreasWeServeResource\Pages;
use App\Filament\Resources\AreasWeServeResource\RelationManagers;
use App\Models\AreasWeServe;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AreasWeServeResource extends Resource
{
    protected static ?string $model = AreasWeServe::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-map-pin';

    protected static string | \UnitEnum | null $navigationGroup = 'Content & Pages';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Service Area Information')
                    ->description('Manage the areas where Danielle Fence provides services')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        TextInput::make('title')
                            ->label('Area Name')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., Lakeland, Tampa, Orlando')
                            ->helperText('Enter the city, neighborhood, or region name'),

                        TextInput::make('slug')
                            ->label('URL Slug')
                            ->maxLength(191)
                            ->placeholder('auto-generated from title')
                            ->helperText('Used in page URLs (e.g., /fencing-lakeland)')
                            ->disabled(),

                        TextInput::make('county')
                            ->label('County')
                            ->maxLength(191)
                            ->placeholder('e.g., Polk, Hillsborough, Orange')
                            ->helperText('Florida county name'),
                    ])
                    ->columns(2),

                Section::make('SEO Information')
                    ->description('Search engine optimization settings')
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(255)
                            ->placeholder('e.g., Fence Installation in Lakeland, FL | Danielle Fence')
                            ->helperText('Page title for search engines (60 chars recommended)'),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(160)
                            ->rows(3)
                            ->placeholder('Professional fence installation services in Lakeland, Florida...')
                            ->helperText('Description for search engines (160 chars recommended)'),
                    ])
                    ->columns(1),

                Section::make('Services Content')
                    ->description('Unique content about fencing services in this area')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        ChatGPTRichEditor::make('services_content')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Section::make('Location Details')
                    ->description('Geographic information for map backgrounds')
                    ->icon('heroicon-o-globe-alt')
                    ->schema([
                        TextInput::make('latitude')
                            ->label('Latitude')
                            ->numeric()
                            ->step(0.00000001)
                            ->placeholder('28.0395')
                            ->helperText('Decimal degrees (auto-populated)'),

                        TextInput::make('longitude')
                            ->label('Longitude')
                            ->numeric()
                            ->step(0.00000001)
                            ->placeholder('-81.9498')
                            ->helperText('Decimal degrees (auto-populated)'),
                    ])
                    ->columns(2),

                Section::make('Display Settings')
                    ->description('Control how this area appears on the website')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        Toggle::make('published')
                            ->label('Published')
                            ->helperText('Show this area on the website')
                            ->default(true)
                            ->inline(false),

                        TextInput::make('sort_order')
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
                TextColumn::make('sort_order')
                    ->label('Order')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->width('80px'),

                TextColumn::make('title')
                    ->label('Area Name')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-map-pin')
                    ->weight('medium'),

                ToggleColumn::make('published')
                    ->label('Published')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable(),

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
            ->defaultSort('sort_order', 'asc')
            ->filters([
                TernaryFilter::make('published')
                    ->label('Publication Status')
                    ->boolean()
                    ->trueLabel('Published areas')
                    ->falseLabel('Unpublished areas')
                    ->native(false),
            ])
            ->recordActions([
                Action::make('toggle_published')
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
                ViewAction::make()
                    ->color('info'),
                EditAction::make()
                    ->color('warning'),
                DeleteAction::make()
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->update(['published' => true]);
                        })
                        ->requiresConfirmation(),
                    BulkAction::make('unpublish')
                        ->label('Unpublish Selected')
                        ->icon('heroicon-o-eye-slash')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each->update(['published' => false]);
                        })
                        ->requiresConfirmation(),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateAction::make(),
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
            'index' => ListAreasWeServes::route('/'),
            'create' => CreateAreasWeServe::route('/create'),
            'view' => ViewAreasWeServe::route('/{record}'),
            'edit' => EditAreasWeServe::route('/{record}/edit'),
        ];
    }
}
