<?php

namespace App\Filament\Resources;

use App\Models\QuoteRequest;
use App\Models\Contact;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\QuoteRequestResource\Pages;
use Illuminate\Database\Eloquent\Builder;

class QuoteRequestResource extends Resource
{
    protected static ?string $model = QuoteRequest::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    // protected static ?string $navigationGroup = 'Customer Management';
    protected static ?int $navigationSort = 16;
    protected static ?string $navigationLabel = 'Quote Requests';
    protected static ?string $pluralLabel = 'Quote Requests';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Contact & Product')->schema([
                Forms\Components\Select::make('contact_id')
                    ->label('Contact')
                    ->relationship('contact', 'full_name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('first_name')->required(),
                        Forms\Components\TextInput::make('last_name')->required(),
                        Forms\Components\TextInput::make('email')->email()->required(),
                        Forms\Components\TextInput::make('phone')->tel(),
                    ]),
                Forms\Components\Select::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name', fn (Builder $query) => $query->published())
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Forms\Set $set, $state) {
                        if ($state) {
                            $product = Product::find($state);
                            if ($product && $product->base_price) {
                                $set('base_price', $product->base_price);
                            }
                        }
                    }),
                Forms\Components\Select::make('status')
                    ->options([
                        'new' => 'New',
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'quoted' => 'Quoted',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('new')
                    ->required(),
            ])->columns(3),

            Forms\Components\Section::make('Quote Details')->schema([
                Forms\Components\RichEditor::make('details')
                    ->label('Additional Details')
                    ->maxLength(2000)
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('DIY Options')->schema([
                Forms\Components\TextInput::make('color')
                    ->maxLength(100)
                    ->placeholder('e.g., White, Black, Brown'),
                Forms\Components\TextInput::make('height')
                    ->maxLength(100)
                    ->placeholder('e.g., 6ft, 4ft, 8ft'),
                Forms\Components\TextInput::make('picket_width')
                    ->label('Picket Width')
                    ->maxLength(100)
                    ->placeholder('e.g., 3in, 4in, 6in'),
            ])->columns(3),

            Forms\Components\Section::make('Pricing')->schema([
                Forms\Components\TextInput::make('base_price')
                    ->label('Base Price')
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01)
                    ->minValue(0),
                Forms\Components\TextInput::make('calculated_price')
                    ->label('Final Calculated Price')
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01)
                    ->minValue(0),
                Forms\Components\RichEditor::make('pricing_notes')
                    ->label('Pricing Notes')
                    ->maxLength(500)
                    ->placeholder('Internal notes about pricing calculations'),
            ])->columns(2),

            Forms\Components\Section::make('Customer Satisfaction')->schema([
                \Yepsua\Filament\Forms\Components\Rating::make('customer_satisfaction_rating')
                    ->label('Customer Satisfaction Rating')
                    ->max(5)
                    ->helperText('Rate the overall customer satisfaction for this quote request (1-5 stars)')
                    ->visible(fn ($context, $record) => $context === 'edit' && $record?->status === 'completed'),
                Forms\Components\RichEditor::make('service_notes')
                    ->label('Service Notes')
                    ->maxLength(1000)
                    ->helperText('Internal notes about the service quality and customer feedback')
                    ->visible(fn ($context, $record) => $context === 'edit' && $record?->status === 'completed')
                    ->columnSpanFull(),
            ])->columns(1),

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
                Tables\Columns\TextColumn::make('id')
                    ->label('Quote #')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => '#' . str_pad($state, 4, '0', STR_PAD_LEFT)),
                Tables\Columns\TextColumn::make('contact.full_name')
                    ->label('Contact')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('contact.email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'new' => 'New',
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'quoted' => 'Quoted',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->selectablePlaceholder(false)
                    ->disabled(fn ($record): bool => in_array($record->status, ['completed', 'cancelled'])),
                Tables\Columns\TextColumn::make('calculated_price')
                    ->label('Price')
                    ->money('usd')
                    ->sortable(),
                Tables\Columns\ViewColumn::make('customer_satisfaction_rating')
                    ->label('Satisfaction')
                    ->view('filament.tables.columns.star-rating')
                    ->visible(fn ($record) => $record?->customer_satisfaction_rating !== null)
                    ->sortable(),
                Tables\Columns\TextColumn::make('color')
                    ->searchable()
                    ->badge()
                    ->color('info')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('height')
                    ->searchable()
                    ->badge()
                    ->color('warning')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('tags.name')
                    ->badge()
                    ->separator(',')
                    ->limit(3)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Requested')
                    ->dateTime()
                    ->sortable()
                    ->since(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'quoted' => 'Quoted',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->multiple(),
                Tables\Filters\SelectFilter::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('contact_id')
                    ->label('Contact')
                    ->relationship('contact', 'full_name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('has_price')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('calculated_price'))
                    ->label('Has Price'),
                Tables\Filters\Filter::make('this_week')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]))
                    ->label('This Week'),
                Tables\Filters\Filter::make('high_value')
                    ->query(fn (Builder $query): Builder => $query->where('calculated_price', '>', 1000))
                    ->label('High Value (>$1000)'),
            ])
            ->actions([
                Tables\Actions\Action::make('duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function (QuoteRequest $record) {
                        $newRecord = $record->replicate();
                        $newRecord->status = 'new';
                        $newRecord->save();
                        
                        return redirect()->route('filament.admin.resources.quote-request-resource.edit', $newRecord);
                    })
                    ->requiresConfirmation(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('mark_quoted')
                        ->label('Mark as Quoted')
                        ->icon('heroicon-o-currency-dollar')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'quoted']);
                            });
                        })
                        ->requiresConfirmation()
                        ->color('success'),
                    Tables\Actions\BulkAction::make('mark_in_progress')
                        ->label('Mark as In Progress')
                        ->icon('heroicon-o-clock')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'in_progress']);
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
            'index' => Pages\ListQuoteRequestResource::route('/'),
            'create' => Pages\CreateQuoteRequestResource::route('/create'),
            'view' => Pages\ViewQuoteRequestResource::route('/{record}'),
            'edit' => Pages\EditQuoteRequestResource::route('/{record}/edit'),
        ];
    }
}
