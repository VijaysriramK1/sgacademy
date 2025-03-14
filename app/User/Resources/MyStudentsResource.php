<?php

namespace App\User\Resources;

use App\User\Resources\MyStudentsResource\Pages;
use App\User\Resources\MyStudentsResource\RelationManagers;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Enrollment;
use App\Models\BatchPrograms;
use App\Models\AssignStaffBatchProgram;
use App\Models\Studentparents;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use App\Helpers\UserHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MyStudentsResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Program';

    protected static ?string $navigationLabel = 'My Student';

    protected static ?int $navigationSort = 4;

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

                Tables\Columns\TextColumn::make('admission_no')
                ->label('Admission No')
                ->getStateUsing(function ($record) {
                    if ($record->admission_no != '' && $record->admission_no != NULL) {
                        return $record->admission_no;
                    } else {
                        return '--';
                    }
                }),

                Tables\Columns\TextColumn::make('name')
                ->label('Student Name')
                ->getStateUsing(function ($record) {
                    return $record->first_name . ' ' . $record->last_name;
                })
                ->searchable(['first_name', 'last_name']),


                Tables\Columns\TextColumn::make('dob')
                ->label('Date Of Birth')
                ->getStateUsing(function ($record) {
                    if ($record->dob != '' && $record->dob != NULL) {
                        return Carbon::parse($record->dob)->format('d-m-Y');
                    } else {
                        return '--';
                    }
                }),


                Tables\Columns\TextColumn::make('gender')
                ->label('Gender')
                ->getStateUsing(function ($record) {
                    if ($record->gender != '' && $record->gender != NULL) {
                        return $record->gender;
                    } else {
                        return '--';
                    }
                }),

                Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->getStateUsing(function ($record) {
                    if ($record->status == 1) {
                       return 'Approved';
                    } else if ($record->status == 2) {
                        return 'Unapproved';
                    } else {}
                })
                ->color(function ($state) {
                    if($state == 'Approved'){
                        return 'success';
                    } else if ($state == 'Unapproved') {
                        return 'danger';
                    } else {}
                }),
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
                        return $query->whereIn('id', Enrollment::where('batch_program_id', $data['batch_program'])->pluck('student_id'));
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
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function canAccess(): bool
    {
        $role = UserHelper::currentRole();

        if ($role == 'parent' || $role == 'staff') {
            $get_permissions = UserHelper::currentRolePermissionDetails();

            if (in_array('my-students', $get_permissions)) {
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
            return parent::getEloquentQuery()->whereIn('id', Studentparents::where('parent_id', UserHelper::currentRoleDetails()->id)->pluck('student_id'));
        } else {
            return parent::getEloquentQuery()->whereIn('id', Enrollment::whereIn('batch_program_id', AssignStaffBatchProgram::where('staff_id', UserHelper::currentRoleDetails()->id)->pluck('batch_program_id'))->pluck('student_id'));
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
            'index' => Pages\ListMyStudents::route('/'),
        ];
    }
}
