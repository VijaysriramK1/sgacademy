<?php

namespace App\Admin\Resources;

use App\Admin\Resources\ParticipantAnswerResource\Pages;
use App\Admin\Resources\ParticipantAnswerResource\RelationManagers;
use App\Models\ParticipantAnswer;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParticipantAnswerResource extends Resource
{
    protected static ?string $model = ParticipantAnswer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Online Exam';

    protected static ?string $navigationLabel = 'Participant Answer';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Participant Answer')->schema([
                    Select::make('exam_participant_id')->relationship('examParticipant.student', 'first_name')->label('Exam Participant')->native(false)->preload()->searchable(),
                    Select::make('question_id')->relationship('question', 'title')->label('Question')->native(false)->preload()->searchable(),
                    TextInput::make('answer')->label('Answer'),
                    TextInput::make('mark')->label('Mark')->numeric(),
                    TextInput::make('error_mark')->label('Error Mark')->numeric(),


                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('examParticipant.student.first_name')
                    ->label('Exam Participant')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('question.title')->label('Question')->searchable()->sortable(),
                TextColumn::make('answer')->label('Answer')->searchable()->sortable(),
                TextColumn::make('mark')->label('Mark')->searchable()->sortable(),
                TextColumn::make('error_mark')->label('Error Mark')->searchable()->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListParticipantAnswers::route('/'),
            'create' => Pages\CreateParticipantAnswer::route('/create'),
            'edit' => Pages\EditParticipantAnswer::route('/{record}/edit'),
        ];
    }
}
