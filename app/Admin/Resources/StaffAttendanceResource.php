<?php

namespace App\Admin\Resources;

use App\Admin\Resources\StaffAttendanceResource\Pages;
use App\Admin\Resources\StaffAttendanceResource\RelationManagers;
use App\Models\Staff;
use App\Models\StaffAttendance;
use Filament\Forms;
use Carbon\Carbon;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\DateColumn;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StaffAttendanceResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    protected static ?string $navigationGroup = 'Human Resource';

    protected static ?string $navigationLabel = 'Staff Attendance';

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

                Tables\Columns\TextColumn::make('name')
                ->label('Staff Name')
                ->getStateUsing(function ($record) {
                    return $record->first_name . ' ' . $record->last_name;
                })
                ->searchable(['first_name', 'last_name']),

                Tables\Columns\TextColumn::make('date')
                ->label('Attendance Date')
                ->getStateUsing(function ($record) {
                    if (Session::has('choosed_date') && !empty(Session::get('choosed_date'))) {
                        $attendance_date = Session::get('choosed_date');
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
                    if (Session::has('choosed_date') && !empty(Session::get('choosed_date'))) {
                        $attendance_date = Session::get('choosed_date', now()->toDateString());
                    $check_record = StaffAttendance::whereDate('date', $attendance_date)
                        ->where('staff_id', $record->id)
                        ->first();
                        return $check_record ? $check_record->status : 5;
                    } else {
                        return 5;
                    }
                })
                ->afterStateUpdated(function ($state, $record) {
                    if (Session::has('choosed_date') && !empty(Session::get('choosed_date'))) {

                    $attendance_date = Session::get('choosed_date', now()->toDateString());
                    $check_staff_attendance = StaffAttendance::whereDate('date', $attendance_date)->where('staff_id', $record->id)->first();

                    if ($state != 0 && $state != '' && $state != NULL && $state != 'null') {
                        $get_state = $state;
                    } else {
                        $get_state = 5;
                    }

                        if (!empty($check_staff_attendance)) {
                            StaffAttendance::where('id', $check_staff_attendance->id)->update([
                                'status' => $get_state,
                            ]);
                        } else {
                            $add_details = new StaffAttendance();
                            $add_details->staff_id = $record->id;
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
                        Notification::make()
                        ->title('Date Not Selected!')
                        ->danger()
                        ->body("Please select an attendance date from the filter before updating the status.")
                        ->send();
                    }
                })->extraAttributes(['style' => 'width: 200px;'])
            ])
            ->filters([
                Filter::make('date')
                ->label('Attendance Date')
                ->form([
                    DatePicker::make('date')->label('Date')->maxDate(now()),
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['date'])) {
                        Session::put('choosed_date', $data['date']);
                    } else {
                        Session::forget('choosed_date');
                    }
                }),
            ])
            ->emptyState(fn() => new HtmlString('<div style="text-align: center; font-size: 18px; font-weight: bold; color: #888; margin-top: 25px; margin-bottom: 25px;">No records found.</div>'))
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
            'index' => Pages\ListStaffAttendances::route('/'),
        ];
    }
}
