<?php

namespace App\Admin\Resources;

use App\Admin\Resources\LeaveResource\Pages;
use App\Admin\Resources\LeaveResource\RelationManagers;
use Carbon\Carbon;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Leave;
use App\Models\LeaveType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\SelectColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
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
        Forms\Components\Section::make('Apply Leave Details')
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
                ->reactive()
                ->label('Staff')
                ->required(),


                Forms\Components\Select::make('leave_type_id')
                ->options(function () {
                    return \App\Models\LeaveType::all()->pluck('name', 'id');
                })
                ->live()
                ->reactive()
                ->label('Leave Type')
                ->required(),


                Select::make('type_id')
                ->label('Leave Details')
                ->options([
                    1 => 'Full Day',
                    2 => 'Half Day',
                ])
                ->required()
                ->default(1)
                ->reactive(),

                Select::make('status')
                ->label('Status')
                ->options([
                    1 => 'Pending',
                    2 => 'Approved',
                    3 => 'Disapproved',
                ])
                ->required()
                ->default(1)
                ->reactive(),

                DatePicker::make('start_date')
                ->label('Start Date')
                ->displayFormat('d-m-Y')
                ->required(),

                DatePicker::make('end_date')
                ->label('End date')
                ->displayFormat('d-m-Y')
                ->required(),

                SelectColumn::make('status')
                ->label('Status')
                ->options([
                   '1' => 'Pending',
                   '2' => 'Approved',
                   '3' => 'Disapproved',
                ])
                ->default('1')
                ->afterStateUpdated(function ($state, $record) {
                    Leave::where('id', $record->id)->update(['status' => $state]);

                    Notification::make()
                    ->title('Message')
                    ->body('Successfully Updated.')
                    ->success()
                    ->send();
              })
              ->getStateUsing(function ($record) {
                $check_record = Leave::where('id', $record->id)->first();
                return $check_record ? $check_record->status : 1;
            })
            ->extraAttributes(['style' => 'width: 200px;']),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')->label('S.No')
                ->rowIndex(),

                Tables\Columns\TextColumn::make('user_id')
                ->label('Name')
                ->getStateUsing(function ($record) {
                    if ($record->role_id == 2) {
                        $check_record = Student::where('user_id', $record->user_id)->first();
                    } else if ($record->role_id == 4) {
                        $check_record = Staff::where('user_id', $record->user_id)->first();
                    } else {
                        $check_record = '';
                    }

                    if ($check_record != '') {
                        return $check_record->first_name . ' ' . $check_record->last_name;
                    } else {
                        return '--';
                    }
                }),

                Tables\Columns\TextColumn::make('role_id')
                ->label('Category')
                ->badge()
                ->getStateUsing(function ($record) {
                    if ($record->role_id == 2) {
                        $set_category = 'Student';
                    } else if ($record->role_id == 4) {
                        $set_category = 'Staff';
                    } else {
                        $set_category = '';
                    }

                    if ($set_category != '') {
                        return $set_category;
                    } else {
                        return 'draft';
                    }
                })
                ->color(fn (string $state): string => match ($state) {
                    'draft' => 'gray',
                    'Student' => 'info',
                    'Staff' => 'primary',
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
                Filter::make('category')
                ->label('Category')
                ->form([
                    Select::make('category')
                    ->label('Category')
                    ->options([
                        'student' => 'Student',
                        'staff' => 'Staff',
                    ])
                    ->placeholder('Select a category')
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['category'])) {
                        if ($data['category'] == 'student') {
                           $role_id = 2;
                        } else {
                            $role_id = 4;
                        }
                        return $query->where('role_id', $role_id);
                    } else {
                        return $query;
                    }
                }),


                Filter::make('status')
                ->label('Status')
                ->form([
                    Select::make('status')
                    ->label('Status')
                    ->options([
                        '1' => 'Pending',
                        '2' => 'Approved',
                        '3' => 'Disapproved',
                    ])
                    ->placeholder('Select a status')
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['status'])) {
                        return $query->where('status', $data['status']);
                    } else {
                        return $query;
                    }
                }),
            ])
            ->actions([
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
            'index' => Pages\ListLeave::route('/'),
        ];
    }
}
