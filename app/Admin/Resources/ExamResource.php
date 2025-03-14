<?php

namespace App\Admin\Resources;

use App\Admin\Resources\ExamResource\Pages;
use App\Admin\Resources\ExamResource\RelationManagers;
use App\Models\Exam;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExamResource extends Resource
{
    protected static ?string $model = Exam::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Examination';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Add Exam';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Add Exam')
                ->schema([
                    Select::make('exam_type_id')->relationship('examtype','title')->searchable()->preload()->native(false),
                    TextInput::make('total_mark')->numeric()->required(),
                    TextInput::make('pass_mark')->numeric(),
                    DatePicker::make('date'),
                    TimePicker::make('start_time'),
                    TimePicker::make('end_time'),
                    Select::make('staff_id')->relationship('staff','first_name')->searchable()->preload()->native(false),
                   
                    Select::make('program_id')->relationship('prograss','name')->searchable()->preload()->native(false),
                    Select::make('semester_id')->relationship('semester','name')->searchable()->preload()->native(false),
                    Select::make('course_id')->relationship('Course','name')->searchable()->preload()->native(false),
                    Select::make('section_id')->relationship('section','name')->searchable()->preload()->native(false),
                    Select::make('batch_id')->relationship('batch','name')->searchable()->preload()->native(false),
                    Radio::make('status')
                    ->options([
                     '1' => 'Active',
                     '0' => 'Inactive',
                    ])->default(1),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('id')->label('Sl')->searchable()->sortable(),
            TextColumn::make('examtype.title')->label('Exam Type')->searchable()->sortable(),
            TextColumn::make('total_mark')->label('Total Mark')->searchable()->sortable(),
            TextColumn::make('pass_mark')->label('Pass Mark')->searchable()->sortable(),
            TextColumn::make('date')->label('Date')->searchable()->sortable(),
            TextColumn::make('start_time')->label('Start Time')->searchable()->sortable(),
            TextColumn::make('end_time')->label('End Time')->searchable()->sortable(),
            TextColumn::make('staff.first_name')->label('Staff')->searchable()->sortable(),
            TextColumn::make('prograss.name')->label('Progress')->searchable()->sortable(),
            TextColumn::make('semester.name')->label('Semester')->searchable()->sortable(),
            TextColumn::make('course.name')->label('Course')->searchable()->sortable(),
            TextColumn::make('section.name')->label('Section')->searchable()->sortable(),
            TextColumn::make('batch.name')->label('Batch')->searchable()->sortable(),
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
                Tables\Actions\ViewAction::make()
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
            'index' => Pages\ListExams::route('/'),
            'create' => Pages\CreateExam::route('/create'),
            'edit' => Pages\EditExam::route('/{record}/edit'),
        ];
    }
}
