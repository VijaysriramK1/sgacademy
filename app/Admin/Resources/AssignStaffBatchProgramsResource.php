<?php

namespace App\Admin\Resources;

use App\Models\Batch;
use App\Models\Staff;
use App\Models\Courses;
use App\Models\Semester;
use App\Models\courseSection;
use App\Models\BatchPrograms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MultiSelect;
use App\Admin\Resources\AssignStaffBatchProgramsResource\Pages;
use App\Admin\Resources\AssignStaffBatchProgramsResource\RelationManagers;
use App\Models\AssignCourse;
use App\Models\AssignStaffBatchProgram;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Illuminate\Support\HtmlString;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssignStaffBatchProgramsResource extends Resource
{
    protected static ?string $model = AssignStaffBatchProgram::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Batches';

    protected static ?string $navigationLabel = 'Assign Staff';

    protected static ?int $navigationSort = 12;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Assign Staff Details')
                ->schema([

                    Forms\Components\Select::make('staff_id')
                    ->options(function () {
                        return Staff::all()->pluck('first_name', 'id')
                            ->mapWithKeys(function ($first_name, $id) {
                                $last_name = Staff::find($id)->last_name;
                                return [$id => $first_name . ' ' . $last_name];
                            });
                    })
                    ->live()
                    ->reactive()
                    ->label('Staff')
                    ->required(),

                    Forms\Components\Select::make('batch_program_id')
                    ->options(function () {
                        return BatchPrograms::where('status', 1)->pluck('batch_group', 'id');
                    })
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('semester_id', null);
                    })
                    ->reactive()
                    ->label('Batch Program')
                    ->required(),

                    Forms\Components\Select::make('semester_id')
                    ->options(function (Get $get) {
                        $batchProgramId = $get('batch_program_id');

                        if (!$batchProgramId) {
                            return [];
                        } else {
                            $check_record = Semester::whereIn('id', courseSection::where('batch_program_id', $batchProgramId)->pluck('semester_id'))->get();

                            if ($check_record->isNotEmpty()) {
                               return $check_record->pluck('name', 'id');
                            } else {
                                return [];
                            }
                        }
                    })
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('course_id', null);
                    })
                    ->reactive()
                    ->label('Semester')
                    ->required(),

                    Forms\Components\MultiSelect::make('course_id')
                    ->options(function (Get $get) {
                        $semesterId = $get('semester_id');

                        if (!$semesterId) {
                            return [];
                        } else {
                            $check_record = courseSection::where('batch_program_id', $get('batch_program_id'))->where('semester_id', $semesterId)->first();
                            if (!empty($check_record)) {
                                return Courses::whereIn('id', $check_record->courses)->pluck('name', 'id');
                            } else {
                                return [];
                            }
                        }
                    })
                    ->label('Courses')
                    ->required(),


                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')->label('S.No')
                ->rowIndex(),

                Tables\Columns\TextColumn::make('staff_id')
                ->label('Staff')
                ->getStateUsing(function ($record) {
                    $check_record = Staff::where('id', $record->staff_id)->first();
                    if (!empty($check_record)) {
                        return $check_record->first_name . ' ' . $check_record->last_name;
                    } else {
                        return '--';
                    }
                  }),


                  Tables\Columns\TextColumn::make('batch_program_id')
                  ->label('Batch Program')
                  ->getStateUsing(function ($record) {
                    $batch_program = BatchPrograms::where('id', $record->batch_program_id)->value('batch_group');
                       return $batch_program ?? '--';
                    }),

                    Tables\Columns\TextColumn::make('semester_id')
                     ->label('Semester')
                     ->getStateUsing(function ($record) {
                       $check_semester = Semester::where('id', $record->semester_id)->value('name');
                         return $check_semester ?? '--';
                    }),

                  Tables\Columns\TextColumn::make('course_id')
                  ->label('Courses')
                  ->getStateUsing(function ($record) {
                      $check_record = Courses::whereIn('id', $record->course_id)->get();

                      $badges = $check_record->map(function ($course) {
                        return'<span style="margin-left: 5px;background-color: #3B82F6;color: white;padding: 4px 8px;text-align: center;border-radius: 5px;">' . $course->name . '</span>';
                    });

                    $chunkedBadges = $badges->chunk(3);

                    return $chunkedBadges->map(function ($chunk) {
                        return '<div style="margin-top: 5px;display: flex; flex-wrap: wrap;">' . $chunk->implode('') . '</div>';
                    })->implode('');

                    })->html(),
            ])
            ->filters([
                //
            ])
            ->emptyState(fn() => new HtmlString('<div style="text-align: center; font-size: 18px; font-weight: bold; color: #888; margin-top: 25px; margin-bottom: 25px;">No records found.</div>'))
            ->actions([
                DeleteAction::make()
                ->action(function ($record) {
                    AssignCourse::where('assign_staff_batch_program_id', $record->id)->delete();
                    $record->delete();
                }),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListAssignStaffBatchPrograms::route('/'),
            'create' => Pages\CreateAssignStaffBatchPrograms::route('/create'),
        ];
    }
}
