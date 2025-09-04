<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DIYOrderResource\Pages;
use App\Models\DIYOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Notifications\Notification;

class DIYOrderResource extends Resource
{
    protected static ?string $model = DIYOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    
    protected static ?string $navigationGroup = 'Sales';
    
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'DIY Orders';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::pending()->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Order Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('order_number')
                                    ->label('Order Number')
                                    ->disabled()
                                    ->dehydrated(false),
                                    
                                Forms\Components\Select::make('status')
                                    ->options(DIYOrder::STATUS_OPTIONS)
                                    ->required()
                                    ->native(false),
                                    
                                Forms\Components\Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                    
                                Forms\Components\TextInput::make('quantity')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1),
                            ]),
                    ]),
                    
                Section::make('Specifications')
                    ->schema([
                        Forms\Components\KeyValue::make('specifications')
                            ->schema([
                                Forms\Components\TextInput::make('height')->label('Height'),
                                Forms\Components\TextInput::make('width')->label('Width'),
                                Forms\Components\TextInput::make('color')->label('Color'),
                            ])
                            ->addActionLabel('Add Specification')
                            ->keyLabel('Specification')
                            ->valueLabel('Value'),
                    ]),
                    
                Section::make('Customer Information')
                    ->schema([
                        Forms\Components\KeyValue::make('customer_info')
                            ->schema([
                                Forms\Components\TextInput::make('name')->label('Name'),
                                Forms\Components\TextInput::make('email')->label('Email')->email(),
                                Forms\Components\TextInput::make('phone')->label('Phone'),
                                Forms\Components\TextInput::make('address')->label('Address'),
                                Forms\Components\TextInput::make('city')->label('City'),
                                Forms\Components\TextInput::make('state')->label('State'),
                                Forms\Components\TextInput::make('zip')->label('ZIP'),
                            ])
                            ->keyLabel('Field')
                            ->valueLabel('Value'),
                    ]),
                    
                Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->rows(3)
                            ->columnSpanFull(),
                            
                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('processed_by')
                                    ->relationship('processor', 'name')
                                    ->searchable()
                                    ->preload(),
                                    
                                Forms\Components\DateTimePicker::make('processed_at'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Order number copied'),
                    
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereRaw("JSON_EXTRACT(customer_info, '$.name') LIKE ?", ["%{$search}%"]);
                    })
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('specifications')
                    ->label('Specs')
                    ->formatStateUsing(fn ($record) => $record->getFormattedSpecifications())
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->getFormattedSpecifications()),
                    
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'processing',
                        'success' => 'ready',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ordered')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(DIYOrder::STATUS_OPTIONS)
                    ->multiple(),
                    
                Filter::make('pending')
                    ->query(fn (Builder $query): Builder => $query->pending())
                    ->label('Pending Only')
                    ->toggle(),
                    
                Filter::make('today')
                    ->query(fn (Builder $query): Builder => $query->today())
                    ->label('Today\'s Orders'),
                    
                Filter::make('this_week')
                    ->query(fn (Builder $query): Builder => $query->thisWeek())
                    ->label('This Week'),
                    
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('process')
                    ->label('Process')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (DIYOrder $record): bool => $record->isPending())
                    ->requiresConfirmation()
                    ->action(function (DIYOrder $record): void {
                        $record->markAsProcessed(auth()->id());
                        
                        Notification::make()
                            ->title('Order Processed')
                            ->body("Order {$record->order_number} has been marked as processing.")
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('markAsProcessing')
                        ->label('Mark as Processing')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records): void {
                            foreach ($records as $record) {
                                if ($record->isPending()) {
                                    $record->markAsProcessed(auth()->id());
                                }
                            }
                            
                            Notification::make()
                                ->title('Orders Updated')
                                ->body(count($records) . ' orders marked as processing.')
                                ->success()
                                ->send();
                        }),
                        
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListDIYOrders::route('/'),
            'create' => Pages\CreateDIYOrder::route('/create'),
            'view' => Pages\ViewDIYOrder::route('/{record}'),
            'edit' => Pages\EditDIYOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            DIYOrderResource\Widgets\DIYOrderStats::class,
        ];
    }
}
