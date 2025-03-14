<?php

namespace App\Admin\Resources;

use App\Admin\Resources\EnrollmentResource\Pages;
use App\Admin\Resources\EnrollmentResource\RelationManagers;
use App\Models\Enrollment;
use App\Models\BatchPrograms;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
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

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Student Info';

    protected static ?string $navigationLabel = 'Assign Student';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Assign Student')
                    ->schema([
                        Select::make('student_id')
                            ->relationship('student', 'first_name')->searchable()->native(false)->preload()->required(),
                            Select::make('batch_program_id')
                            ->options(function () {
                                return BatchPrograms::where('status', 1)->pluck('batch_group', 'id');
                             })
                             ->label('Batch Program')
                             ->native(false)
                             ->required(),

                        DatePicker::make('enrolled_at')->label('Enrolled At')->required(),
                        Select::make('badge_id')->relationship('badge', 'title')->searchable()->native(false)->preload(),
                        select::make('student_category_id')->relationship('studentCategory', 'name')->searchable()->native(false)->preload(),
                        Select::make('student_group_id')->relationship('studentGroup', 'name')->searchable()->native(false)->preload(),
                        Radio::make('is_promote')->label('Is Promote')
                        ->options([
                            '1' => 'Promote',
                            '0' => 'Not Promote',
                        ])->default(1),
                    Radio::make('is_graduate')->label('Is Graduate')
                        ->options([
                            '1' => 'Graduate',
                            '0' => 'Not Graduate',
                            ])->default(1),
                    Radio::make('is_default')->label('Is Default')
                        ->options([
                            '1' => 'Default',
                            '0' => 'Not Default',
                            ])->default(1),

                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sl')->rowIndex(),
                Tables\Columns\TextColumn::make('batch_program_id')
                ->label('Batch Program')
                ->getStateUsing(function ($record) {
                    $batch_program = BatchPrograms::where('id', $record->batch_program_id)->value('batch_group');
                       return $batch_program ?? '--';
                }),
                TextColumn::make('student.first_name')->label('Student Name'),
                TextColumn::make('enrolled_at')->label('Enrolled At'),
                TextColumn::make('badge.title')->label('Badge'),
                TextColumn::make('studentCategory.name')->label('Student Category'),
                TextColumn::make('studentGroup.name')->label('Student Group'),
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
            'index' => Pages\ListEnrollments::route('/'),
            'create' => Pages\CreateEnrollment::route('/create'),
            'edit' => Pages\EditEnrollment::route('/{record}/edit'),
        ];
    }
}
