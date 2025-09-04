<?php

namespace App\Filament\Resources;

use App\Models\Application;
use App\Models\Career;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\ApplicationResource\Pages;
use Illuminate\Database\Eloquent\Builder;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationGroup = 'HR';
    protected static ?string $navigationLabel = 'Applications';
    protected static ?string $pluralLabel = 'Applications';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Application Details')->schema([
                Forms\Components\Select::make('career_id')
                    ->label('Job Position')
                    ->relationship('career', 'title', fn (Builder $query) => $query->published())
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'reviewing' => 'Reviewing',
                        'interviewed' => 'Interviewed',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending')
                    ->required(),
            ])->columns(2),

            Forms\Components\Section::make('Personal Information')->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(20),
            ])->columns(2),

            Forms\Components\Section::make('Cover Letter')->schema([
                Forms\Components\RichEditor::make('cover_letter')
                    ->columnSpanFull()
                    ->maxLength(5000),
            ]),

            Forms\Components\Section::make('Resume')->schema([
                Forms\Components\FileUpload::make('resume')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(5120)
                    ->downloadable()
                    ->openable()
                    ->directory('applications/resumes')
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('career.title')
                    ->label('Position')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable()
                    ->copyable(),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'reviewing' => 'Reviewing',
                        'interviewed' => 'Interviewed',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ])
                    ->selectablePlaceholder(false)
                    ->disabled(fn ($record): bool => in_array($record->status, ['accepted', 'rejected'])),
                Tables\Columns\IconColumn::make('has_resume')
                    ->label('Resume')
                    ->getStateUsing(fn ($record) => $record->getFirstMedia('resume') !== null)
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Applied')
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
                        'pending' => 'Pending',
                        'reviewing' => 'Reviewing',
                        'interviewed' => 'Interviewed',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ])
                    ->multiple(),
                Tables\Filters\SelectFilter::make('career_id')
                    ->label('Position')
                    ->relationship('career', 'title')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('has_resume')
                    ->query(fn (Builder $query): Builder => $query->whereHas('media'))
                    ->label('Has Resume'),
                Tables\Filters\Filter::make('applied_this_week')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]))
                    ->label('Applied This Week'),
            ])
            ->actions([
                Tables\Actions\Action::make('download_resume')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Application $record) {
                        $resume = $record->getFirstMedia('resume');
                        if ($resume) {
                            return response()->download($resume->getPath(), $resume->file_name);
                        }
                    })
                    ->visible(fn (Application $record) => $record->getFirstMedia('resume') !== null),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('mark_reviewing')
                        ->label('Mark as Reviewing')
                        ->icon('heroicon-o-eye')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'reviewing']);
                            });
                        })
                        ->requiresConfirmation()
                        ->color('info'),
                    Tables\Actions\BulkAction::make('mark_interviewed')
                        ->label('Mark as Interviewed')
                        ->icon('heroicon-o-chat-bubble-left-right')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'interviewed']);
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
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'view' => Pages\ViewApplication::route('/{record}'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}