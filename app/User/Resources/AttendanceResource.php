<?php

namespace App\User\Resources;

use App\User\Resources\AttendanceResource\Pages;
use App\User\Resources\AttendanceResource\RelationManagers;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\Courses;
use App\Models\Batch;
use App\Models\Enrollment;
use App\Models\Semester;
use App\Models\BatchPrograms;
use App\Models\AssignStaffBatchProgram;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Helpers\UserHelper;
use Illuminate\Support\Facades\Session;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    protected static ?string $navigationLabel = 'Attendance';

    protected static ?int $navigationSort = 3;


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
                Tables\Columns\TextColumn::make('index')->label('S.No')
                ->rowIndex(),

                Tables\Columns\TextColumn::make('name')
                ->label('Student Name')
                ->getStateUsing(function ($record) {
                    return $record->first_name . ' ' . $record->last_name;
                })
                ->searchable(['first_name', 'last_name']),

                Tables\Columns\TextColumn::make('course_id')
                ->label('Course Name')
                ->getStateUsing(function ($record) {
                    if (Session::has('choosed_student_attendance_course') && !empty(Session::get('choosed_student_attendance_course'))) {
                        return Courses::where('id', Session::get('choosed_student_attendance_course'))->first()->name;
                    } else {
                        return '--';
                    }
                }),

                Tables\Columns\TextColumn::make('date')
                ->label('Attendance Date')
                ->getStateUsing(function ($record) {
                    if (Session::has('choosed_student_attendance_date') && !empty(Session::get('choosed_student_attendance_date'))) {
                        $attendance_date = Session::get('choosed_student_attendance_date');
                        return Carbon::parse($attendance_date)->format('d-m-Y');
                    } else {
                        return '--';
                    }
                }),

                SelectColumn::make('status')
                ->label('Attendance Status')
                ->options([
                    1 => 'Present',
                    2 => 'Absent',
                    3 => 'Late',
                    4 => 'Halfday',
                    5 => 'Pending',
                ])
                ->default(5)
                ->getStateUsing(function ($record) {
                    if (Session::has('choosed_student_attendance_date') && !empty(Session::get('choosed_student_attendance_date')) && Session::has('choosed_student_attendance_course') && !empty(Session::get('choosed_student_attendance_course'))) {
                        $attendance_date = Session::get('choosed_student_attendance_date', now()->toDateString());
                    $check_record = StudentAttendance::whereDate('date', $attendance_date)
                        ->where('course_id', Session::get('choosed_student_attendance_course'))
                        ->where('student_id', $record->id)
                        ->first();
                        return $check_record ? $check_record->status : 5;
                    } else {
                        return 5;
                    }
                })
                ->afterStateUpdated(function ($state, $record) {
                    if (Session::has('choosed_student_attendance_date') && !empty(Session::get('choosed_student_attendance_date')) && Session::has('choosed_student_attendance_batch_program') && !empty(Session::get('choosed_student_attendance_batch_program')) && Session::has('choosed_student_attendance_course') && !empty(Session::get('choosed_student_attendance_course'))) {

                    $attendance_date = Session::get('choosed_student_attendance_date', now()->toDateString());
                    $check_student_attendance = StudentAttendance::whereDate('date', $attendance_date)->where('batch_program_id', Session::get('choosed_student_attendance_batch_program'))->where('semester_id', Session::get('choosed_student_attendance_semester'))->where('course_id', Session::get('choosed_student_attendance_course'))->where('student_id', $record->id)->first();

                    if ($state != 0 && $state != '' && $state != NULL && $state != 'null') {
                        $get_state = $state;
                    } else {
                        $get_state = 5;
                    }

                        if (!empty($check_student_attendance)) {
                            StudentAttendance::where('id', $check_student_attendance->id)->update([
                                'status' => $get_state,
                            ]);
                        } else {
                            $add_details = new StudentAttendance();
                            $add_details->student_id = $record->id;
                            $add_details->batch_program_id = Session::get('choosed_student_attendance_batch_program');
                            $add_details->semester_id = Session::get('choosed_student_attendance_semester');
                            $add_details->course_id = Session::get('choosed_student_attendance_course');
                            $add_details->date = $attendance_date;
                            $add_details->status = $get_state;
                            $add_details->save();
                        }

                        Notification::make()
                            ->title('Attendance Status Updated')
                            ->success()
                            ->body("The attendance status for the selected date has been successfully updated.")
                            ->send();

                } else {
                    if (!Session::has('choosed_student_attendance_date') && empty(Session::get('choosed_student_attendance_date')) && !Session::has('choosed_student_attendance_batch_program') && empty(Session::get('choosed_student_attendance_batch_program')) && !Session::has('choosed_student_attendance_course') && empty(Session::get('choosed_student_attendance_course'))) {
                        Notification::make()
                         ->title('Date, Batch Program and Course Not Selected!')
                         ->danger()
                         ->body("Please select both an attendance date, batch program and a course from the filter before updating the status.")
                         ->send();
                    } else if (!Session::has('choosed_student_attendance_date') && empty(Session::get('choosed_student_attendance_date'))){
                        Notification::make()
                        ->title('Date Not Selected!')
                        ->danger()
                        ->body("Please select an attendance date from the filter before updating the status.")
                        ->send();
                    } else if(!Session::has('choosed_student_attendance_batch_program') && empty(Session::get('choosed_student_attendance_batch_program'))) {
                        Notification::make()
                        ->title('Batch Program Not Selected!')
                        ->danger()
                        ->body("Please select a batch program from the filter before updating the status.")
                        ->send();
                    } else if (!Session::has('choosed_student_attendance_course') && empty(Session::get('choosed_student_attendance_course'))) {
                         Notification::make()
                         ->title('Course Not Selected!')
                         ->danger()
                         ->body("Please select a course from the filter before updating the status.")
                         ->send();
                    } else {}

                    }
                })->extraAttributes(['style' => 'width: 200px;'])
            ])
            ->filters([
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
                    if ($data['batch_program']) {
                        Session::put('choosed_student_attendance_batch_program', $data['batch_program']);
                        return $query->whereIn('id', Enrollment::where('batch_program_id', $data['batch_program'])->pluck('student_id'));
                    } else {
                        Session::forget('choosed_student_attendance_batch_program');
                        Session::forget('choosed_student_attendance_course');
                        return $query;
                    }
                }),

                Filter::make('semester')
                ->label('Semester')
                ->form([
                    Select::make('semester')
                    ->label('Semester')
                    ->options(function () {
                       $batch_program = AssignStaffBatchProgram::where('batch_program_id', Session::get('choosed_student_attendance_batch_program'))->get();
                       if ($batch_program->isNotEmpty()) {
                          return Semester::whereIn('id', $batch_program->pluck('semester_id'))->pluck('name', 'id');
                       } else {
                          return [];
                       }
                    })
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['semester'])) {
                        Session::put('choosed_student_attendance_semester', $data['semester']);
                    } else {
                        Session::forget('choosed_student_attendance_semester');
                    }
                }),

                Filter::make('course_name')
                ->label('Course Name')
                ->form([
                    Select::make('course_name')
                    ->label('Course Name')
                    ->options(function () {
                       $batch_program = AssignStaffBatchProgram::where('batch_program_id', Session::get('choosed_student_attendance_batch_program'))->where('semester_id', Session::get('choosed_student_attendance_semester'))->first();
                       if (!empty($batch_program)) {
                          return Courses::whereIn('id', $batch_program->course_id)->pluck('name', 'id');
                       } else {
                          return [];
                       }
                    })
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['course_name'])) {
                        Session::put('choosed_student_attendance_course', $data['course_name']);
                    } else {
                        Session::forget('choosed_student_attendance_course');
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
                        Session::put('choosed_student_attendance_date', $data['date']);
                    } else {
                        Session::forget('choosed_student_attendance_date');
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
        if ($role == 'staff') {
            $get_permissions = UserHelper::currentRolePermissionDetails();
            if (in_array('attendances', $get_permissions)) {
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
        return parent::getEloquentQuery()->whereIn('id', Enrollment::whereIn('batch_program_id', AssignStaffBatchProgram::where('staff_id', UserHelper::currentRoleDetails()->id)->pluck('batch_program_id'))->pluck('student_id'));
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
            'index' => Pages\ListAttendances::route('/'),
        ];
    }
}
