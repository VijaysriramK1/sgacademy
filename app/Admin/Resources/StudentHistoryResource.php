<?php

namespace App\Admin\Resources;

use App\Admin\Resources\StudentHistoryResource\Pages;
use App\Admin\Resources\StudentHistoryResource\RelationManagers;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\StudentHistory;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\DateFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentHistoryResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Student Report';

    protected static ?string $navigationLabel = 'Student History';

    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.admission_no')->searchable()->sortable(),
                TextColumn::make('student.first_name')->searchable()->sortable(),
                TextColumn::make('student.admission_date')->searchable()->sortable(),
                TextColumn::make('student.batchProgram.batch.name')->searchable()->sortable(),
                TextColumn::make('student.batchProgram.program.name')->searchable()->sortable(),
                TextColumn::make('student.mobile')->searchable()->sortable(),
                TextColumn::make('student.email')->searchable()->sortable(),
                
            ])
            ->filters([
              
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
            'index' => Pages\ListStudentHistories::route('/'),
            'create' => Pages\CreateStudentHistory::route('/create'),
            'edit' => Pages\EditStudentHistory::route('/{record}/edit'),
        ];
    }
}
