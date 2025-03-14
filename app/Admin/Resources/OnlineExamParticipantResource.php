<?php

namespace App\Admin\Resources;

use App\Admin\Resources\OnlineExamParticipantResource\Pages;
use App\Admin\Resources\OnlineExamParticipantResource\RelationManagers;
use App\Models\OnlineExamParticipant;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OnlineExamParticipantResource extends Resource
{
    protected static ?string $model = OnlineExamParticipant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Online Exam';

    protected static ?string $navigationLabel = 'Participant';

    protected static ?int $navigationSort = 5;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Participant')->schema([
                    Select::make('online_exam_id')
                        ->label('Online Exam')
                        ->relationship('onlineExam', 'title')
                        ->required(),

                    Select::make('student_id')
                        ->label('Student')
                        ->relationship('student', 'first_name')
                        ->required(),

                    Select::make('enrollment_id')
                        ->label('Enrollment')
                        ->relationship('enrollment', 'roll_no')
                        ->required(),

                    TextInput::make('mark')
                        ->label('Mark')
                        ->numeric()
                        ->nullable(),

                    TextInput::make('error_mark')
                        ->label('Error Mark')
                        ->numeric()
                        ->nullable(),

                    section::make()->schema([
                        Radio::make('abs')
                            ->label('Absent')
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ])
                            ->default(0),
                        Radio::make('status')
                            ->label('Status')
                            ->options([
                                1 => 'Active',
                                0 => 'Inactive',
                            ])
                            ->default(1)
                    ])->columns(2)

                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('onlineExam.title')
                ->label('Online Exam')
                ->searchable()
                ->sortable(),

            TextColumn::make('student.first_name')
                ->label('Student')
                ->searchable()
                ->sortable(),

            // TextColumn::make('enrollment.id')
            //     ->label('Enrollment ID')
            //     ->sortable(),

            TextColumn::make('mark')
                ->label('Mark')
                ->sortable(),

            TextColumn::make('error_mark')
                ->label('Error Mark')
                ->sortable(),

                IconColumn::make('abs')
                ->label('Absent')
                ->icon(fn($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                ->color(fn($state) => $state ? 'success' : 'danger')->searchable()->sortable(),

            TextColumn::make('status')
                ->formatStateUsing(fn($state) => match ($state) {
                    1 => 'Active',
                    0 => 'Inactive',
                })
                ->badge()
                ->color(fn($state) => match ($state) {
                    1 => 'success',
                    0 => 'danger',
                })->searchable()->sortable(),

            ])
            ->filters([
                SelectFilter::make('status')
                ->options([
                    1 => 'Active',
                    0 => 'Inactive',
                ])
                ->label('Status')
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
            'index' => Pages\ListOnlineExamParticipants::route('/'),
            'create' => Pages\CreateOnlineExamParticipant::route('/create'),
            'edit' => Pages\EditOnlineExamParticipant::route('/{record}/edit'),
        ];
    }
}
