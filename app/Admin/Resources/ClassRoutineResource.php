<?php

namespace App\Admin\Resources;

use App\Admin\Resources\ClassRoutineResource\Pages;
use App\Admin\Resources\ClassRoutineResource\RelationManagers;
use Carbon\Carbon;
use App\Models\Semester;
use App\Models\Batch;
use App\Models\BatchPrograms;
use App\Models\AssignCourse;
use App\Models\AssignStaffBatchProgram;
use App\Models\Routine;
use App\Models\Staff;
use App\Models\Courses;
use App\Models\lesson;
use App\Models\Topic;
use App\Models\courseSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\MultiSelect;
use Filament\Tables\Columns\SelectColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Session;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassRoutineResource extends Resource
{
    protected static ?string $model = Routine::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Batches';

    protected static ?string $navigationLabel = 'Class Routine';

    protected static ?int $navigationSort = 13;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Add Routines Details')
                ->schema([

                    Forms\Components\Select::make('staff_id')
                    ->options(function () {
                        return \App\Models\Staff::all()->pluck('first_name', 'id')
                            ->mapWithKeys(function ($first_name, $id) {
                                $last_name = \App\Models\Staff::find($id)->last_name;
                                return [$id => $first_name . ' ' . $last_name];
                            });
                    })
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('batch_program_id', null);
                    })
                    ->reactive()
                    ->label('Staff')
                    ->required(),


                    Forms\Components\Select::make('batch_program_id')
                    ->options(function (Get $get) {
                        $staffId = $get('staff_id');

                        if (!$staffId) {
                            return [];
                        }

                        return BatchPrograms::whereIn('id', AssignStaffBatchProgram::where('staff_id', $staffId)->pluck('batch_program_id'))->pluck('batch_group', 'id');
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

                    Forms\Components\Select::make('course_id')
                    ->options(function (Get $get) {
                        $semesterId = $get('semester_id');

                        if (!$semesterId) {
                            return [];
                        } else {
                            $check_record = AssignStaffBatchProgram::where('staff_id', $get('staff_id'))->where('batch_program_id', $get('batch_program_id'))->where('semester_id', $semesterId)->first();
                            if (!empty($check_record)) {
                                return Courses::whereIn('id', $check_record->course_id)->pluck('name', 'id');
                            } else {
                                return [];
                            }
                        }
                    })
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('lesson_id', null);
                    })
                    ->reactive()
                    ->label('Course')
                    ->required(),

                    Forms\Components\Select::make('lesson_id')
                    ->options(function (Get $get) {

                        $courseId = $get('course_id');

                        if (!$courseId) {
                            return [];
                        }

                        return \App\Models\lesson::where('course_id', $courseId)->pluck('title', 'id');
                    })
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('topic_id', null);
                    })
                    ->reactive()
                    ->label('Lesson')
                    ->required(),

                    Forms\Components\MultiSelect::make('topic_id')
                    ->options(function (Get $get) {

                        $lessonId = $get('lesson_id');

                        if (!$lessonId) {
                            return [];
                        }

                        return \App\Models\Topic::where('lesson_id', $lessonId)->pluck('title', 'id');
                    })
                    ->label('Topics')
                    ->required(),

                    Forms\Components\MultiSelect::make('day')
                    ->options([
                        'Monday' => 'Monday',
                        'Tuesday' => 'Tuesday',
                        'Wednesday' => 'Wednesday',
                        'Thursday' => 'Thursday',
                        'Friday' => 'Friday',
                        'Saturday' => 'Saturday',
                        'Sunday' => 'Sunday',
                    ])
                    ->label('Days')
                    ->required()
                    ->visible(fn ($record) => $record === null),
                    ])->columns(2),

                    Forms\Components\Section::make('Date & Timing Details')
                    ->schema([
                        DatePicker::make('start_date')
                        ->label('Start Date')
                        ->displayFormat('d-m-Y')
                        ->required(),

                        DatePicker::make('end_date')
                        ->label('End date')
                        ->displayFormat('d-m-Y')
                        ->required()
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                            $startDate = $get('start_date');
                            if ($startDate && $state && Carbon::parse($state)->isBefore(Carbon::parse($startDate))) {
                                Notification::make()
                                    ->title('End Date should be after Start Date!')
                                    ->danger()
                                    ->send();
                                $set('end_date', null);
                            }
                        }),

                        TimePicker::make('start_time')
                        ->label('Start Time')
                        ->displayFormat('H:i')
                        ->required(),

                        TimePicker::make('end_time')
                        ->label('End Time')
                        ->displayFormat('H:i')
                        ->required()
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                            $startTime = $get('start_time');
                            if ($startTime && $state && Carbon::parse($state)->lessThanOrEqualTo(Carbon::parse($startTime))) {
                                Notification::make()
                                    ->title('End Time should be after Start Time!')
                                    ->danger()
                                    ->send();
                                $set('end_time', null);
                            }
                        }),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')->label('S.No')
                ->rowIndex(),

                Tables\Columns\TextColumn::make('day')
                ->label('Day')
                ->getStateUsing(function ($record) {
                    $check_record = DB::table('routines')->where('id', $record->id)->first();
                    if (!empty($check_record)) {
                        return $check_record->day;
                    } else {
                        return '--';
                    }
                  }),

                Tables\Columns\TextColumn::make('staff_id')
                  ->label('Staff Name')
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

                Tables\Columns\TextColumn::make('start_date')
                ->label('Start Date')
                ->getStateUsing(function ($record) {
                  if ($record->start_date != '' && $record->start_date != NULL) {
                    return Carbon::parse($record->start_date)->format('d-m-Y');
                  } else {
                      return '--';
                  }
                }),

                Tables\Columns\TextColumn::make('end_date')
                ->label('End Date')
                ->getStateUsing(function ($record) {
                  if ($record->end_date != '' && $record->end_date != NULL) {
                    return Carbon::parse($record->end_date)->format('d-m-Y');
                  } else {
                      return '--';
                  }
              }),

              SelectColumn::make('status')
              ->label('Status')
              ->options([
                 'Pending' => 'Pending',
                 'Completed' => 'Completed',
              ])
              ->default('Pending')
              ->afterStateUpdated(function ($state, $record) {
                if ($state == 'Completed') {
                    $date = Carbon::now();
                } else {
                    $date = '';
                }

                Routine::where('id', $record->id)->update([
                    'status' => $state,
                    'completed_date' => $date,
                ]);

                Notification::make()
                ->title('Successfully Updated')
                ->success()
                ->body("The selected routine status has been successfully updated.")
                ->send();
              })
              ->getStateUsing(function ($record) {
                  $check_record = Routine::where('id', $record->id)->first();
                  return $check_record ? $check_record->status : 'Pending';
                })
                ->extraAttributes(['style' => 'width: 200px;']),

            ])
            ->filters([
                Filter::make('day')
                ->label('Day')
                ->form([
                    Select::make('day')
                        ->options([
                            'Monday' => 'Monday',
                            'Tuesday' => 'Tuesday',
                            'Wednesday' => 'Wednesday',
                            'Thursday' => 'Thursday',
                            'Friday' => 'Friday',
                            'Saturday' => 'Saturday',
                            'Sunday' => 'Sunday',
                        ])->default('All'),
                ])
                ->query(function (Builder $query, array $data) {
                    if ($data['day'] == 'All') {
                        return $query;
                    } else {
                        return $query->where('day', $data['day']);
                    }
                }),
            ])
            ->emptyState(fn() => new HtmlString('<div style="text-align: center; font-size: 18px; font-weight: bold; color: #888; margin-top: 25px; margin-bottom: 25px;">No records found.</div>'))
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListClassRoutines::route('/'),
            'create' => Pages\CreateClassRoutine::route('/create'),
            'edit' => Pages\EditClassRoutine::route('/{record}/edit'),
        ];
    }
}
