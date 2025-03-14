<?php

namespace App\Admin\Resources\LessonResource\RelationManagers;

use App\Admin\Resources\LessonResource;
use App\Admin\Resources\LessonResource\Pages\Subtopic;
use Filament\Tables\Actions\ActionGroup;
use App\Admin\Resources\LessonResource\Pages\ViewSubtopic;
use App\Admin\Resources\TopicResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;

class TopicsRelationManager extends RelationManager
{
    protected static string $relationship = 'topics';

    protected static ?string $recordTitleAttribute = 'title';


    protected static bool $shouldRegisterNavigation = true;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('content')
                    ->nullable()
                    ->maxLength(65535),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sl')->rowIndex(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

            ])
            ->headerActions([
                CreateAction::make()
                    ->visible(true)
                    ->icon('heroicon-m-plus')
                    ->label('Add Topic')
                    ->authorize(true),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label('Add Subtopics')
                        ->icon('heroicon-o-plus-circle')
                        ->url(fn($record) => TopicResource::getUrl('view-subtopic', ['record' => $record->id])),
                    EditAction::make()
                        ->visible(true)
                        ->authorize(true),
                    DeleteAction::make()
                        ->visible(true)
                        ->authorize(true),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    protected function canCreate(): bool
    {
        return true;
    }

    protected function canEdit(mixed $record): bool
    {
        return true;
    }

    protected function canDelete(mixed $record): bool
    {
        return true;
    }

    public static function getPages(): array
    {
        return [

            'view' => ViewSubtopic::route('/{record}')
        ];
    }
}
