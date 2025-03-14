<?php

namespace App\User\Resources;

use Carbon\Carbon;
use App\User\Resources\LeaveResource\Pages;
use App\User\Resources\LeaveResource\RelationManagers;
use App\Models\User;
use App\Models\Leave;
use App\Models\Student;
use App\Models\Studentparents;
use App\Models\LeaveType;
use App\Helpers\UserHelper;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeaveResource extends Resource
{
    protected static ?string $model = Leave::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Leave';

    protected static ?string $navigationLabel = 'Leave';

    protected static ?int $navigationSort = 2;

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

                Tables\Columns\TextColumn::make('user_id')
                ->label('Student Name')
                ->getStateUsing(function ($record) {
                    $get_details = Student::where('user_id', $record->user_id)->first();
                    return "{$get_details->first_name} {$get_details->last_name}";
                })
                ->visible(function ($record) {
                    $role = UserHelper::currentRole();
                    if ($role == 'parent') {
                       return true;
                    } else {
                        return false;
                    }
                }),

                Tables\Columns\TextColumn::make('leave_type_id')
                ->label('Leave Type')
                ->getStateUsing(function ($record) {
                    $leaveType = LeaveType::where('id', $record->leave_type_id)->first();
                    return "{$leaveType->name}";
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

                Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->formatStateUsing(function ($state) {
                    if ($state == 1) {
                        return 'Pending';
                    } else if ($state == 2) {
                        return 'Approved';
                    } else if ($state == 3) {
                        return 'Disapproved';
                    } else {
                    }
                })
                ->color(fn(string $state): string => match ($state) {
                    '1' => 'primary',
                    '2' => 'success',
                    '3' => 'danger',
                }),
            ])
            ->filters([
                Filter::make('Student Name')
                ->label('Student Name')
                ->form([
                    Select::make('selected_student')
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
                    $check_student = Student::where('id', $data['selected_student'])->first();
                    if (!empty($check_student)) {
                        return $query->where('user_id', $check_student->user_id);
                    } else {
                        return null;
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
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                ->visible(function ($record) {
                    $role = UserHelper::currentRole();
                    if ($role == 'student' || $role == 'staff') {
                        if ($record->status == 1) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }),
            ])
            ->bulkActions([]);
    }


    public static function canAccess(): bool
    {
        $role = UserHelper::currentRole();

        if ($role == 'student' || $role == 'parent' || $role == 'staff') {
            $get_permissions = UserHelper::currentRolePermissionDetails();

            if (in_array('leaves', $get_permissions)) {
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
        if ($role == 'parent') {
            return parent::getEloquentQuery()->whereIn('user_id', Student::whereIn('id', Studentparents::where('parent_id', UserHelper::currentRoleDetails()->id)->pluck('student_id'))->pluck('user_id'))->orderBy('id', 'asc');
        } else {
            return parent::getEloquentQuery()->where('user_id', UserHelper::currentRoleDetails()->user_id)->orderBy('id', 'asc');
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
            'index' => Pages\ListLeaves::route('/'),
        ];
    }
}
