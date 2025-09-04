<?php

namespace App\Filament\Resources;

use App\Models\Career;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\CareerResource\Pages;
use Illuminate\Database\Eloquent\Builder;

class CareerResource extends Resource
{
    protected static ?string $model = Career::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'HR';
    protected static ?string $navigationLabel = 'Careers';
    protected static ?string $pluralLabel = 'Careers';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Job Details')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                Forms\Components\TextInput::make('location')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., Remote, New York, NY, etc.'),
            ])->columns(3),

            Forms\Components\Section::make('Job Description')->schema([
                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->columnSpanFull()
                    ->fileAttachmentsDirectory('career-attachments'),
            ]),

            Forms\Components\Section::make('Requirements')->schema([
                Forms\Components\RichEditor::make('requirements')
                    ->columnSpanFull()
                    ->fileAttachmentsDirectory('career-attachments'),
            ]),

            Forms\Components\Section::make('Publishing')->schema([
                Forms\Components\Toggle::make('published')
                    ->default(false)
                    ->live(),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Publish Date')
                    ->visible(fn (Forms\Get $get) => $get('published'))
                    ->default(now()),
            ])->columns(2),

            Forms\Components\Section::make('Tags')->schema([
                Forms\Components\Select::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required(),
                    ])
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\IconColumn::make('published')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('applications_count')
                    ->label('Applications')
                    ->counts('applications')
                    ->sortable()
                    ->badge()
                    ->color('primary'),
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
                Tables\Filters\TernaryFilter::make('published')
                    ->label('Published Status')
                    ->trueLabel('Published')
                    ->falseLabel('Draft')
                    ->nullable(),
                Tables\Filters\SelectFilter::make('location')
                    ->options(function () {
                        return Career::query()
                            ->whereNotNull('location')
                            ->distinct()
                            ->pluck('location', 'location')
                            ->toArray();
                    })
                    ->searchable(),
                Tables\Filters\Filter::make('published_this_month')
                    ->query(fn (Builder $query): Builder => $query->whereMonth('published_at', now()->month))
                    ->label('Published This Month'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCareers::route('/'),
            'create' => Pages\CreateCareer::route('/create'),
            'view' => Pages\ViewCareer::route('/{record}'),
            'edit' => Pages\EditCareer::route('/{record}/edit'),
        ];
    }
}