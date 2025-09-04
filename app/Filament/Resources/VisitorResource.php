<?php

namespace App\Filament\Resources;

use App\Models\Visitor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\VisitorResource\Pages;

class VisitorResource extends Resource
{
    protected static ?string $model = Visitor::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';
    protected static ?string $navigationGroup = 'Analytics';
    protected static ?string $navigationLabel = 'Visitors';
    protected static ?string $pluralLabel = 'Visitors';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Visitor Information')->schema([
                Forms\Components\TextInput::make('ip_address')
                    ->label('IP Address')
                    ->required()
                    ->maxLength(45),
                Forms\Components\TextInput::make('anonymized_ip')
                    ->label('Anonymized IP')
                    ->maxLength(45),
                Forms\Components\Textarea::make('user_agent')
                    ->label('User Agent')
                    ->rows(3)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Location Information')->schema([
                Forms\Components\TextInput::make('country')
                    ->maxLength(100),
                Forms\Components\TextInput::make('city')
                    ->maxLength(100),
                Forms\Components\DateTimePicker::make('visited_at')
                    ->label('Visited At')
                    ->required()
                    ->default(now()),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('city')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('visited_at')
                    ->label('Visited At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('country')
                    ->options(function () {
                        return Visitor::query()
                            ->whereNotNull('country')
                            ->distinct()
                            ->pluck('country', 'country')
                            ->toArray();
                    })
                    ->searchable(),
                Tables\Filters\Filter::make('visited_today')
                    ->query(fn ($query) => $query->whereDate('visited_at', today()))
                    ->label('Visited Today'),
                Tables\Filters\Filter::make('visited_this_week')
                    ->query(fn ($query) => $query->whereBetween('visited_at', [now()->startOfWeek(), now()->endOfWeek()]))
                    ->label('Visited This Week'),
                Tables\Filters\Filter::make('visited_this_month')
                    ->query(fn ($query) => $query->whereMonth('visited_at', now()->month))
                    ->label('Visited This Month'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->tooltip('View detailed visitor information and session data'),
                Tables\Actions\DeleteAction::make()
                    ->tooltip('Remove this visitor record from analytics'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('visited_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisitors::route('/'),
            'view' => Pages\ViewVisitor::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }
}