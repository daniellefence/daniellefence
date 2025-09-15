<?php

namespace App\Filament\Resources;

use App\Models\FAQ;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\FAQResource\Pages;
use Illuminate\Database\Eloquent\Builder;

class FAQResource extends Resource
{
    protected static ?string $model = FAQ::class;
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    // protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationLabel = 'FAQs';
    protected static ?string $pluralLabel = 'FAQs';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('FAQ Details')->schema([
                Forms\Components\TextInput::make('question')
                    ->required()
                    ->maxLength(500)
                    ->columnSpan(2),
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->step(1)
                    ->hint('Lower numbers appear first'),
                Forms\Components\Toggle::make('published')
                    ->default(true),
            ])->columns(3),

            Forms\Components\Section::make('Answer')->schema([
                Forms\Components\RichEditor::make('answer')
                    ->required()
                    ->columnSpanFull()
                    ->fileAttachmentsDirectory('faq-attachments'),
            ]),

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
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable()
                    ->width(60),
                Tables\Columns\TextColumn::make('question')
                    ->searchable()
                    ->sortable()
                    ->limit(80)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 80) {
                            return null;
                        }
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('answer')
                    ->html()
                    ->limit(100)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = strip_tags($column->getState());
                        if (strlen($state) <= 100) {
                            return null;
                        }
                        return $state;
                    }),
                Tables\Columns\IconColumn::make('published')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tags.name')
                    ->badge()
                    ->separator(',')
                    ->limit(3)
                    ->toggleable(),
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
                Tables\Filters\Filter::make('recent')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subWeek()))
                    ->label('Added This Week'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('moveUp')
                        ->icon('heroicon-o-arrow-up')
                        ->action(function (FAQ $record) {
                            $previousRecord = FAQ::where('order', '<', $record->order)
                                ->orderBy('order', 'desc')
                                ->first();
                            
                            if ($previousRecord) {
                                $tempOrder = $record->order;
                                $record->update(['order' => $previousRecord->order]);
                                $previousRecord->update(['order' => $tempOrder]);
                            }
                        })
                        ->visible(fn (FAQ $record) => FAQ::where('order', '<', $record->order)->exists()),
                    Tables\Actions\Action::make('moveDown')
                        ->icon('heroicon-o-arrow-down')
                        ->action(function (FAQ $record) {
                            $nextRecord = FAQ::where('order', '>', $record->order)
                                ->orderBy('order', 'asc')
                                ->first();
                            
                            if ($nextRecord) {
                                $tempOrder = $record->order;
                                $record->update(['order' => $nextRecord->order]);
                                $nextRecord->update(['order' => $tempOrder]);
                            }
                        })
                        ->visible(fn (FAQ $record) => FAQ::where('order', '>', $record->order)->exists()),
                ]),
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
                                $record->update(['published' => true]);
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
            ->defaultSort('order', 'asc')
            ->reorderable('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFAQs::route('/'),
            'create' => Pages\CreateFAQ::route('/create'),
            'view' => Pages\ViewFAQ::route('/{record}'),
            'edit' => Pages\EditFAQ::route('/{record}/edit'),
        ];
    }
}