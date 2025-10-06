<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use App\Filament\Forms\Components\ChatGPTTiptapEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\CreateAction;
use App\Filament\Resources\FaqResource\Pages\ListFaqs;
use App\Filament\Resources\FaqResource\Pages\CreateFaq;
use App\Filament\Resources\FaqResource\Pages\ViewFaq;
use App\Filament\Resources\FaqResource\Pages\EditFaq;
use App\Filament\Resources\FaqResource\Pages;
use App\Filament\Resources\FaqResource\RelationManagers;
use App\Models\Faq;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static string | \UnitEnum | null $navigationGroup = 'Content & Pages';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('FAQ Details')
                    ->description('Manage frequently asked questions and their answers')
                    ->icon('heroicon-o-question-mark-circle')
                    ->schema([
                        TextInput::make('question')
                            ->label('Question')
                            ->required()
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->placeholder('Enter the frequently asked question'),

                        ChatGPTTiptapEditor::make('answer')
                    ->profile('default')
                            ->label('Answer')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                            ])
                            ->placeholder('Provide a detailed answer to the question'),
                    ])
                    ->columns(1),

                Section::make('Display Settings')
                    ->description('Control how this FAQ appears on the website')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        TextInput::make('order')
                            ->label('Display Order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Lower numbers appear first. Use 0 for default ordering.'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order')
                    ->label('Order')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->width('80px'),

                TextColumn::make('question')
                    ->label('Question')
                    ->searchable()
                    ->sortable()
                    ->limit(60)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 60) {
                            return null;
                        }
                        return $state;
                    })
                    ->weight('medium'),

                TextColumn::make('answer')
                    ->label('Answer Preview')
                    ->html()
                    ->limit(80)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = strip_tags($column->getState());
                        if (strlen($state) <= 80) {
                            return null;
                        }
                        return $state;
                    })
                    ->color('gray'),

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
            ->defaultSort('order', 'asc')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->color('info'),
                EditAction::make()
                    ->color('warning'),
                DeleteAction::make()
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
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
            'index' => ListFaqs::route('/'),
            'create' => CreateFaq::route('/create'),
            'view' => ViewFaq::route('/{record}'),
            'edit' => EditFaq::route('/{record}/edit'),
        ];
    }
}
