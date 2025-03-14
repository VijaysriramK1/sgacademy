<?php

namespace App\Admin\Resources;

use App\Admin\Resources\StaffAttendanceReportResource\Pages;
use App\Admin\Resources\StaffAttendanceReportResource\RelationManagers;
use App\Models\Staff;
use App\Models\StaffAttendance;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StaffAttendanceReportResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationGroup = 'Staff Report';

    protected static ?string $navigationLabel = 'Staff Attendance Report';

    protected static ?int $navigationSort = 1;

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
                    if (Session::has('filter_date') && !empty(Session::get('filter_date'))) {
                        $attendance_date = Session::get('filter_date', now()->toDateString());
                    $check_record = StaffAttendance::whereDate('date', $attendance_date)
                        ->where('staff_id', $record->id)
                        ->first();
                        return $check_record ? Carbon::parse($check_record->date)->format('d-m-Y') : '--';
                    } else {
                        return '--';
                    }
                }),

                Tables\Columns\TextColumn::make('status')
                ->label('Attendance Status')
                ->badge()
                ->getStateUsing(function ($record) {
                    if (Session::has('filter_date') && !empty(Session::get('filter_date'))) {
                        $attendance_date = Session::get('filter_date', now()->toDateString());
                        $check_record = StaffAttendance::whereDate('date', $attendance_date)->where('staff_id', $record->id)->first();

                        if (!empty($check_record)) {
                            switch ($check_record->status) {
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
                        } else {
                            return 'Pending';
                        }
                    } else {
                        return 'Pending';
                    }
                })
                ->color(function ($state) {
                    if($state == 'Present'){
                        return 'success';
                    } else if ($state == 'Absent') {
                        return 'danger';
                    } else if ($state == 'Late') {
                        return 'warning';
                    } else if ($state == 'Halfday') {
                        return 'info';
                    } else {
                        return 'primary';
                    }
                }),
            ])
            ->filters([
                Filter::make('date')
                ->label('Attendance Date')
                ->form([
                    DatePicker::make('date')->label('Date'),
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['date'])) {
                        Session::put('filter_date', $data['date']);
                    } else {
                        Session::forget('filter_date');
                    }

                    if (Session::has('filter_date') && !empty(Session::get('filter_date'))) {
                        $attendance_date = Session::get('filter_date', now()->toDateString());
                        $query->whereHas('attendances', function (Builder $query) use ($attendance_date) {
                            $query->whereDate('date', $attendance_date);
                        });
                    }

                })
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
            'index' => Pages\ListStaffAttendanceReports::route('/'),
        ];
    }
}
