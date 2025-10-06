<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\TrafficResource\Pages\ListTraffic;
use App\Filament\Resources\TrafficResource\Pages\CreateTraffic;
use App\Filament\Resources\TrafficResource\Pages\ViewTraffic;
use App\Filament\Resources\TrafficResource\Pages\EditTraffic;
use App\Filament\Resources\TrafficResource\Pages;
use App\Filament\Resources\TrafficResource\RelationManagers;
use App\Models\Traffic;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Carbon\Carbon;

class TrafficResource extends Resource
{
    protected static ?string $model = Traffic::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chart-bar';

    protected static string | \UnitEnum | null $navigationGroup = 'Dashboard & Analytics';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ip')
                    ->maxLength(191),
                Textarea::make('user_agent')
                    ->columnSpanFull(),
                Textarea::make('method')
                    ->columnSpanFull(),
                Textarea::make('source')
                    ->columnSpanFull(),
                Textarea::make('route')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Visit Time')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('route')
                    ->label('Page Visited')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),
                TextColumn::make('source')
                    ->label('Traffic Source')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => empty($state) ? 'Direct' : $state)
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 30 ? $state : null;
                    }),
                TextColumn::make('ip')
                    ->label('IP Address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('method')
                    ->label('HTTP Method')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'GET' => 'success',
                        'POST' => 'warning',
                        'PUT' => 'info',
                        'DELETE' => 'danger',
                        default => 'gray',
                    })
                    ->toggleable(),
                TextColumn::make('user_agent')
                    ->label('Browser Info')
                    ->searchable()
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('method')
                    ->label('HTTP Method')
                    ->options([
                        'GET' => 'GET',
                        'POST' => 'POST',
                        'PUT' => 'PUT',
                        'DELETE' => 'DELETE',
                    ]),
                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('created_from')
                            ->label('Visit Date From'),
                        DatePicker::make('created_until')
                            ->label('Visit Date To'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                Filter::make('today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', Carbon::today()))
                    ->toggle(),
                Filter::make('this_week')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]))
                    ->toggle(),
                Filter::make('this_month')
                    ->query(fn (Builder $query): Builder => $query->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year))
                    ->toggle(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(25);
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
            'index' => ListTraffic::route('/'),
            'create' => CreateTraffic::route('/create'),
            'view' => ViewTraffic::route('/{record}'),
            'edit' => EditTraffic::route('/{record}/edit'),
        ];
    }
}
