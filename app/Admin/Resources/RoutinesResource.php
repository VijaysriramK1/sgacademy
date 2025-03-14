<?php

namespace App\Admin\Resources;

use App\Admin\Resources\RoutinesResource\Pages;
use App\Admin\Resources\RoutinesResource\RelationManagers;
use Carbon\Carbon;
use App\Models\Staff;
use App\Models\Routine;
use App\Models\Semester;
use App\Models\Courses;
use App\Models\lesson;
use App\Models\Topic;
use App\Models\Batch;
use App\Models\BatchPrograms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Filament\Tables\Table;
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
            ->badge()
            ->getStateUsing(function ($record) {
                if ($record->status == 'Completed') {
                   return 'Completed';
                } else {
                    return 'Pending';
                }
            })
            ->color(function ($state) {
                if($state == 'Completed'){
                    return 'success';
                } else {
                    return 'warning';
                }
            }),
        ])
            ->filters([
                Filter::make('batch_program')
                ->label('Batch Program')
                ->form([
                    Select::make('batch_program')
                    ->label('Batch Program')
                    ->options(function () {
                        return BatchPrograms::orderBy('id', 'asc')->pluck('batch_group', 'id');
                    })
                ])
                ->query(function (Builder $query, array $data) {
                    if ($data['batch_program']) {
                        return $query->where('batch_program_id', $data['batch_program']);
                    } else {
                        return $query;
                    }
                }),

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
                        ]),
                ])
                ->query(function (Builder $query, array $data) {
                    if ($data['day']) {
                       return $query->where('day', $data['day']);
                    } else {
                       return $query;
                    }
                }),
            ])
            ->actions([])
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
            'index' => Pages\ListRoutines::route('/'),
        ];
    }
}
