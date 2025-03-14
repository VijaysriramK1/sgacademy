<?php

namespace App\User\Resources;

use App\User\Resources\AttendanceReportResource\Pages;
use App\User\Resources\AttendanceReportResource\RelationManagers;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\Studentparents;
use App\Models\Enrollment;
use App\Models\AssignStaffBatchProgram;
use App\Models\Courses;
use App\Models\Batch;
use App\Models\BatchPrograms;
use App\Models\Semester;
use App\Helpers\UserHelper;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceReportResource extends Resource
{
    protected static ?string $model = StudentAttendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationGroup = 'Report';

    protected static ?string $navigationLabel = 'Attendance Report';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')->label('S.No')
                ->rowIndex(),

                Tables\Columns\TextColumn::make('batch_program_id')
                ->label('Batch Program')
                ->getStateUsing(function ($record) {
                    $batch_program = BatchPrograms::where('id', $record->batch_program_id)->value('batch_group');
                   return $batch_program ?? '--';
                }),

                Tables\Columns\TextColumn::make('student_id')
                ->label('Student Name')
                ->getStateUsing(function ($record) {
                   $check_record = Student::where('id', $record->student_id)->first();
                   if (!empty($check_record)) {
                      return $check_record->first_name . ' ' . $check_record->last_name;
                   } else {
                      return '--';
                   }
                })
                ->visible(function ($record) {
                    $role = UserHelper::currentRole();
                    if ($role == 'parent' || $role == 'staff') {
                       return true;
                    } else {
                        return false;
                    }
                }),


                Tables\Columns\TextColumn::make('semester_id')
                ->label('Semester')
                ->getStateUsing(function ($record) {
                    $semester = Semester::where('id', $record->semester_id)->value('name');
                   return $semester ?? '--';
                }),

                Tables\Columns\TextColumn::make('course_id')
                ->label('Course Name')
                ->getStateUsing(function ($record) {
                   $check_record = Courses::where('id', $record->course_id)->first();
                   if (!empty($check_record)) {
                      return $check_record->name;
                   } else {
                      return '--';
                   }
                }),

                Tables\Columns\TextColumn::make('date')
                ->label('Attendance Date')
                ->getStateUsing(function ($record) {
                    return Carbon::parse($record->date)->format('d-m-Y');
                }),

                Tables\Columns\TextColumn::make('status')
                ->label('Attendance Status')
                ->getStateUsing(function ($record) {
                    switch ($record->status) {
                        case 1:
                            return 'Present';
                        case 2:
                            return 'Absent';
                        case 3:
                            return 'Late';
                        case 4:
                            return 'Halfday';
                        case 5:
                            return 'Pending';
                        default:
                            return 'Pending';
                    }
                }),
            ])
            ->filters([
                Filter::make('student_name')
                ->label('Student Name')
                ->form([
                    Select::make('student_name')
                    ->label('Student Name')
                    ->options(function () {
                        $get_parent_based_students = Studentparents::where('parent_id', UserHelper::currentRoleDetails()->id)->get();
                        return Student::whereIn('id', $get_parent_based_students->pluck('student_id'))->pluck('first_name', 'id')
                            ->mapWithKeys(function ($first_name, $id) {
                                $last_name = Student::find($id)->last_name;
                                return [$id => $first_name . ' ' . $last_name];
                            });
                    })
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['student_name'])) {
                        return $query->where('student_id', $data['student_name']);
                    } else {
                        return $query;
                    }
                })
                ->visible(function () {
                    $role = UserHelper::currentRole();
                    if ($role == 'parent') {
                       return true;
                    } else {
                        return false;
                    }
                }),

                Filter::make('batch_program')
                ->label('Batch Program')
                ->form([
                    Select::make('batch_program')
                    ->label('Batch Program')
                    ->options(function () {
                        return BatchPrograms::whereIn('id', AssignStaffBatchProgram::where('staff_id', UserHelper::currentRoleDetails()->id)->pluck('batch_program_id'))->pluck('batch_group', 'id');
                    })
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['batch_program'])) {
                        return $query->whereIn('student_id',  Enrollment::where('batch_program_id', $data['batch_program'])->pluck('student_id'));
                    } else {
                        return $query;
                    }
                })
                ->visible(function () {
                    $role = UserHelper::currentRole();
                    if ($role == 'staff') {
                       return true;
                    } else {
                       return false;
                    }
                }),

                Filter::make('date')
                ->label('Attendance Date')
                ->form([
                    DatePicker::make('date')
                    ->label('Date')
                    ->maxDate(now()),
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['date'])) {
                        return $query->whereDate('date', $data['date']);
                    } else {
                        return $query;
                    }
                })
            ])
            ->emptyState(fn() => new HtmlString('<div style="text-align: center; font-size: 18px; font-weight: bold; color: #888; margin-top: 25px; margin-bottom: 25px;">No records found.</div>'))
            ->actions([])
            ->bulkActions([]);
    }

    public static function canAccess(): bool
    {
        $role = UserHelper::currentRole();
        if ($role == 'student' || $role == 'staff' || $role == 'parent') {
            $get_permissions = UserHelper::currentRolePermissionDetails();
            if (in_array('attendance-reports', $get_permissions)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $role = UserHelper::currentRole();
        if ($role == 'student') {
            return parent::getEloquentQuery()->where('student_id', UserHelper::currentRoleDetails()->id);
        } else if ($role == 'parent') {
            return parent::getEloquentQuery()->whereIn('student_id', Studentparents::where('parent_id', UserHelper::currentRoleDetails()->id)->pluck('student_id'));
        } else {
            return parent::getEloquentQuery()->whereIn('student_id', Enrollment::whereIn('batch_program_id', AssignStaffBatchProgram::where('staff_id', UserHelper::currentRoleDetails()->id)->pluck('batch_program_id'))->pluck('student_id'));
        }

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
            'index' => Pages\ListAttendanceReports::route('/'),
        ];
    }
}
