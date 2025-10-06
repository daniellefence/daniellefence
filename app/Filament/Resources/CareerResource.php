<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use App\Filament\Forms\Components\ChatGPTRichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\CreateAction;
use App\Filament\Resources\CareerResource\Pages\ListCareers;
use App\Filament\Resources\CareerResource\Pages\CreateCareer;
use App\Filament\Resources\CareerResource\Pages\ViewCareer;
use App\Filament\Resources\CareerResource\Pages\EditCareer;
use App\Filament\Resources\CareerResource\Pages;
use App\Filament\Resources\CareerResource\RelationManagers;
use App\Models\Career;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CareerResource extends Resource
{
    protected static ?string $model = Career::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-briefcase';

    protected static string | \UnitEnum | null $navigationGroup = 'Human Resources';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Job Posting Information')
                    ->description('Manage career opportunities and job postings')
                    ->icon('heroicon-o-briefcase')
                    ->schema([
                        Select::make('user_id')
                            ->label('Posted By')
                            ->options(User::pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('The user who created this job posting'),

                        TextInput::make('title')
                            ->label('Job Title')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., Fence Installer, Project Manager')
                            ->helperText('The title of the job position'),

                        ChatGPTRichEditor::make('content')
                            ->label('Job Description')
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
                            ->placeholder('Detailed job description, requirements, benefits, etc.')
                            ->helperText('Include job responsibilities, qualifications, benefits, and application instructions'),
                    ])
                    ->columns(2),

                Section::make('Display Settings')
                    ->description('Control how this job posting appears on the website')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        TextInput::make('order')
                            ->label('Display Order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Lower numbers appear first in job listings'),

                        Toggle::make('published')
                            ->label('Published')
                            ->helperText('Show this job posting on the careers page')
                            ->default(true)
                            ->inline(false),

                        Toggle::make('hidden')
                            ->label('Hidden')
                            ->helperText('Hide this job posting (overrides published status)')
                            ->default(false)
                            ->inline(false),
                    ])
                    ->columns(3),
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

                TextColumn::make('title')
                    ->label('Job Title')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-o-briefcase'),

                TextColumn::make('user.name')
                    ->label('Posted By')
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                IconColumn::make('status')
                    ->label('Status')
                    ->state(function ($record) {
                        if ($record->hidden) {
                            return false;
                        }
                        return $record->published;
                    })
                    ->boolean()
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->tooltip(function ($record) {
                        if ($record->hidden) {
                            return 'Hidden';
                        }
                        return $record->published ? 'Published' : 'Unpublished';
                    }),

                ToggleColumn::make('published')
                    ->label('Published')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable()
                    ->disabled(fn ($record) => $record->hidden),

                ToggleColumn::make('hidden')
                    ->label('Hidden')
                    ->onIcon('heroicon-o-eye-slash')
                    ->offIcon('heroicon-o-eye')
                    ->onColor('danger')
                    ->offColor('success')
                    ->sortable(),

                TextColumn::make('content')
                    ->label('Description Preview')
                    ->html()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = strip_tags($column->getState());
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Posted Date')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                TrashedFilter::make(),
                TernaryFilter::make('published')
                    ->label('Publication Status')
                    ->boolean()
                    ->trueLabel('Published jobs')
                    ->falseLabel('Unpublished jobs')
                    ->native(false),
                TernaryFilter::make('hidden')
                    ->label('Visibility')
                    ->boolean()
                    ->trueLabel('Hidden jobs')
                    ->falseLabel('Visible jobs')
                    ->native(false),
                SelectFilter::make('user_id')
                    ->label('Posted By')
                    ->options(User::pluck('name', 'id'))
                    ->placeholder('All Users'),
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
                    ->visible(fn ($record) => !$record->hidden),
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
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateAction::make(),
            ])
            ->recordUrl(fn ($record) => null);
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
            'index' => ListCareers::route('/'),
            'create' => CreateCareer::route('/create'),
            'view' => ViewCareer::route('/{record}'),
            'edit' => EditCareer::route('/{record}/edit'),
        ];
    }
}
