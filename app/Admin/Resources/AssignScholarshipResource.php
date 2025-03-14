<?php

namespace App\Admin\Resources;

use App\Admin\Resources\AssignScholarshipResource\Pages;
use App\Admin\Resources\AssignScholarshipResource\RelationManagers;
use App\Models\Stipend;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Scholarship;
use App\Models\StudentScholarship;
use App\Models\Batch;
use App\Models\BatchPrograms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Tables\Actions\DeleteAction;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\SelectColumn;
use Filament\Forms\Components\MultiSelect;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssignScholarshipResource extends Resource
{
    protected static ?string $model = StudentScholarship::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Scholarships';

    protected static ?string $navigationLabel = 'Assign Student';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Assign Scholarship Details')
                ->schema([
                    Forms\Components\Select::make('scholarship_id')
                    ->options(function () {
                        return Scholarship::all()->pluck('name', 'id');
                    })
                    ->label('Scholarship')
                    ->required(),

                    Forms\Components\Select::make('batch_program_id')
                    ->options(function () {
                        return BatchPrograms::orderBy('id', 'asc')->pluck('batch_group', 'id');
                    })
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('student_id', null);
                    })
                    ->reactive()
                    ->label('Batch Program')
                    ->required(),

                    Forms\Components\MultiSelect::make('student_id')
                    ->options(function (Get $get) {

                        $batch_program_id = $get('batch_program_id');

                        if (!$batch_program_id) {
                            return [];
                        }
                        return Student::whereIn('id', Enrollment::where('batch_program_id', $batch_program_id)->pluck('student_id'))->pluck('first_name', 'id')
                        ->mapWithKeys(function ($first_name, $id) {
                            $last_name = Student::find($id)->last_name;
                            return [$id => $first_name . ' ' . $last_name];
                        });
                    })
                    ->label('Student Name')
                    ->required(),

                    Forms\Components\TextInput::make('amount')
                    ->label('Scholarship amount')
                    ->required(),

                    Forms\Components\TextInput::make('stipend_amount')
                    ->label('Stipend Amount')
                    ->required()
                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        $amount = $get('amount');

                        if ($state > $amount) {
                            Notification::make()
                            ->title('Warning Message!')
                            ->body('Stipend Amount must be less than or equal to Scholarship Amount.')
                            ->danger()
                            ->send();
                            $set('stipend_amount', null);
                        }
                    }),

                    DatePicker::make('awarded_date')
                    ->label('Start Date')
                    ->displayFormat('d-m-Y')
                    ->required(),

                ])->columns(2),
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

                Tables\Columns\TextColumn::make('amount')
                ->label('Amount'),

                Tables\Columns\TextColumn::make('stipend_amount')
                ->label('Stipend Amount'),
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
            ->actions([
                DeleteAction::make()
                ->action(function ($record) {
                    Stipend::where('student_scholarship_id', $record->id)->delete();
                    $record->delete();
                })
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
            'index' => Pages\ListAssignScholarships::route('/'),
            'create' => Pages\CreateAssignScholarship::route('/create'),
        ];
    }
}
