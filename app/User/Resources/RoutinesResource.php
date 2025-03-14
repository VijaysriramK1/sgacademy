<?php

namespace App\User\Resources;

use App\User\Resources\RoutinesResource\Pages;
use App\User\Resources\RoutinesResource\RelationManagers;
use Carbon\Carbon;
use App\Models\Routine;
use App\Models\Semester;
use App\Models\Courses;
use App\Models\lesson;
use App\Models\Topic;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Helpers\UserHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoutinesResource extends Resource
{
    protected static ?string $model = Routine::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Program';

    protected static ?string $navigationLabel = 'Routines';

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

                  Tables\Columns\TextColumn::make('semester_id')
                  ->label('Semester')
                  ->getStateUsing(function ($record) {
                      $semester = Semester::where('id', $record->semester_id)->value('name');
                     return $semester ?? '--';
                  }),


                  Tables\Columns\TextColumn::make('course_id')
                  ->label('Course')
                  ->getStateUsing(function ($record) {
                    $check_record = Courses::where('id', $record->course_id)->first();
                    if (!empty($check_record)) {
                      if ($check_record != '' && $check_record != NULL) {
                          return $check_record->name;
                      } else {
                          return '--';
                      }
                    } else {
                        return '--';
                    }
                }),



                Tables\Columns\TextColumn::make('lesson_id')
                ->label('Lesson')
                ->getStateUsing(function ($record) {
                  $check_record = lesson::where('id', $record->lesson_id)->first();
                  if (!empty($check_record)) {
                    if ($check_record != '' && $check_record != NULL) {
                        return $check_record->title;
                    } else {
                        return '--';
                    }
                  } else {
                      return '--';
                  }
              }),


              Tables\Columns\TextColumn::make('topic_id')
              ->label('Topic')
              ->getStateUsing(function ($record) {
                $check_record = Topic::whereIn('id', $record->topic_id)->pluck('title');
                if (!empty($check_record)) {
                  return $check_record;
                } else {
                  return '--';
                }
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



          Tables\Columns\TextColumn::make('completed_date')
          ->label('Completed Date')
          ->getStateUsing(function ($record) {
            if ($record->completed_date != '' && $record->completed_date != NULL) {
              return Carbon::parse($record->completed_date)->format('d-m-Y');
            } else {
                return '--';
            }
        }),


        Tables\Columns\TextColumn::make('status')
        ->label('Status')
        ->getStateUsing(function ($record) {
          if ($record->status != '' && $record->status != NULL) {
            return $record->status;
          } else {
              return '--';
          }
      }),
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
            ->actions([])
            ->bulkActions([]);
    }

    public static function canAccess(): bool
    {

        $role = UserHelper::currentRole();

        if ($role == 'student' || $role == 'staff') {
            $get_permissions = UserHelper::currentRolePermissionDetails();
            if (in_array('routines', $get_permissions)) {
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
            return parent::getEloquentQuery()->whereIn('batch_program_id', Enrollment::where('student_id', UserHelper::currentRoleDetails()->id)->pluck('batch_program_id'));
        } else {
            return parent::getEloquentQuery()->where('staff_id', UserHelper::currentRoleDetails()->id);
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
            'index' => Pages\ListRoutines::route('/'),
        ];
    }
}
