<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Filament\Resources\SiteSettingResource\RelationManagers;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    // protected static ?string $navigationGroup = 'Business Settings';
    protected static ?int $navigationSort = 21;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Setting Details')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('Setting Key')
                            ->required()
                            ->unique(SiteSetting::class, 'key', ignoreRecord: true)
                            ->disabled(fn ($record) => $record !== null), // Disable editing existing keys
                        Forms\Components\TextInput::make('label')
                            ->label('Label')
                            ->required(),
                        Forms\Components\Select::make('type')
                            ->label('Type')
                            ->options([
                                'text' => 'Text',
                                'textarea' => 'Textarea',
                                'boolean' => 'Boolean',
                                'json' => 'JSON',
                                'file' => 'File',
                            ])
                            ->required()
                            ->reactive(),
                        Forms\Components\Select::make('group')
                            ->label('Group')
                            ->options([
                                'seo' => 'SEO',
                                'company' => 'Company',
                                'analytics' => 'Analytics',
                                'social' => 'Social',
                                'general' => 'General',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_public')
                            ->label('Public')
                            ->helperText('Can this setting be accessed from frontend?')
                            ->default(false),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Value')
                    ->schema([
                        Forms\Components\TextInput::make('value')
                            ->label('Value')
                            ->visible(fn (Forms\Get $get) => in_array($get('type'), ['text'])),
                        Forms\Components\Textarea::make('value')
                            ->label('Value')
                            ->rows(4)
                            ->visible(fn (Forms\Get $get) => in_array($get('type'), ['textarea'])),
                        Forms\Components\Toggle::make('value')
                            ->label('Value')
                            ->visible(fn (Forms\Get $get) => in_array($get('type'), ['boolean'])),
                        Forms\Components\Textarea::make('value')
                            ->label('Value (JSON)')
                            ->rows(6)
                            ->helperText('Enter valid JSON')
                            ->visible(fn (Forms\Get $get) => in_array($get('type'), ['json'])),
                        Forms\Components\FileUpload::make('value')
                            ->label('File')
                            ->visible(fn (Forms\Get $get) => in_array($get('type'), ['file'])),
                        Forms\Components\RichEditor::make('description')
                            ->label('Description')
                            ->helperText('Optional description for this setting'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Setting Key')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('label')
                    ->label('Label')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Value')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) > 50) {
                            return $state;
                        }
                        return null;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('group')
                    ->label('Group')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'seo' => 'success',
                        'company' => 'info',
                        'analytics' => 'warning',
                        'social' => 'primary',
                        default => 'secondary',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_public')
                    ->label('Public')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->options([
                        'seo' => 'SEO',
                        'company' => 'Company',
                        'analytics' => 'Analytics',
                        'social' => 'Social',
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Textarea',
                        'boolean' => 'Boolean',
                        'json' => 'JSON',
                        'file' => 'File',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('group')
            ->defaultSort('sort_order');
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
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
