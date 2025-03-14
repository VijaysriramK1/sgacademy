<?php

namespace App\Admin\Resources;

use Carbon\Carbon;
use App\Admin\Resources\StipendResource\Pages;
use App\Admin\Resources\StipendResource\RelationManagers;
use App\Models\Stipend;
use App\Models\Student;
use App\Models\Batch;
use App\Models\BatchPrograms;
use App\Models\Scholarship;
use Filament\Forms;
use App\Models\StudentScholarship;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\SelectColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Session;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StipendResource extends Resource
{
    protected static ?string $model = Stipend::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Scholarships';

    protected static ?string $navigationLabel = 'Add Stipend';

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

                Tables\Columns\TextColumn::make('scholarship_id')
                ->label('Scholarship Name')
                ->getStateUsing(function ($record) {
                    $check_record = Scholarship::where('id', $record->scholarship_id)->first();
                    return $check_record->name ?? '--';
                }),

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
                    return $check_record->first_name . ' ' . $check_record->last_name;
                }),

                SelectColumn::make('interval_type')
                  ->label('Interval Type')
                  ->options([
                     'monthly' => 'Monthly',
                     'yearly' => 'Yearly',
                  ])
                  ->default('')
                  ->afterStateUpdated(function ($state, $record) {
                    Session::put('interval_type_row_' . $record->id, $state);
                    Stipend::where('id', $record->id)->update([
                        'interval_type' => NULL,
                    ]);
                })
                ->getStateUsing(function ($record) {
                    if (Session::has('interval_type_row_' . $record->id) && !empty(Session::get('interval_type_row_' . $record->id))) {
                        $interval_type_value = Session::get('interval_type_row_' . $record->id);
                        return $interval_type_value;
                    } else {
                        $check_record = Stipend::where('id', $record->id)->first();
                        return $check_record ? $check_record->interval_type : NULL;
                    }
                })
                ->extraAttributes(['style' => 'width: 200px;']),

                TextInputColumn::make('cycle_count')
                   ->label('Cycle Count')
                   ->afterStateUpdated(function ($state, $record) {
                    Session::put('cycle_count_row_' . $record->id, $state);
                      Stipend::where('id', $record->id)->update([
                        'cycle_count' => NULL,
                      ]);
                    })
                    ->getStateUsing(function ($record) {
                        if (Session::has('cycle_count_row_' . $record->id) && !empty(Session::get('cycle_count_row_' . $record->id))) {
                            $cycle_count_value = Session::get('cycle_count_row_' . $record->id);
                            return $cycle_count_value;
                        } else {
                            $check_record = Stipend::where('id', $record->id)->first();
                            return $check_record ? $check_record->cycle_count : NULL;
                        }
                    })
                    ->extraAttributes(['style' => 'width: 200px;']),
                    Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->getStateUsing(function ($record) {
                        if ($record->amount != '' && $record->amount != NULL) {
                            return $record->amount;
                        } else {
                           return '--';
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
            ])
            ->emptyState(fn() => new HtmlString('<div style="text-align: center; font-size: 18px; font-weight: bold; color: #888; margin-top: 25px; margin-bottom: 25px;">No records found.</div>'))
            ->actions([])
            ->bulkActions([])
            ->headerActions([
                Tables\Actions\Action::make('save_all')
                    ->label('Save')
                    ->color('success')
                    ->action(function (Table $table) {
                        $records = $table->getRecords();
                        foreach ($records as $record) {
                            $get_interval_type = Session::get('interval_type_row_' . $record->id);
                            $get_cycle_count = Session::get('cycle_count_row_' . $record->id);

                            $interval_type = !empty($get_interval_type) ? $get_interval_type : null;
                            $cycle_count = !empty($get_cycle_count) ? $get_cycle_count : null;
                            $check_record = StudentScholarship::where('id', $record->student_scholarship_id)->first();

                            if ($interval_type !== null && $cycle_count !== null) {
                                $get_amount = $check_record->stipend_amount / $cycle_count;
                                Stipend::where('id', $record->id)->update([
                                    'interval_type' => $interval_type,
                                    'cycle_count' => $cycle_count,
                                    'amount' => $get_amount,
                                ]);
                            } else {
                                Stipend::where('id', $record->id)->update([
                                    'updated_at' => Carbon::now(),
                                ]);
                            }
                        }
                        Notification::make()
                        ->title('Successfully Updated')
                        ->success()
                        ->body("The student for the selected stipend has been successfully updated.")
                        ->send();
                    }),
            ]);
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
            'index' => Pages\ListStipends::route('/'),
        ];
    }
}
