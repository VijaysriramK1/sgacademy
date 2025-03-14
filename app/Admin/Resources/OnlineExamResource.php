<?php

namespace App\Admin\Resources;

use App\Admin\Resources\OnlineExamResource\Pages;
use App\Admin\Resources\OnlineExamResource\RelationManagers;
use App\Models\OnlineExam;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OnlineExamResource extends Resource
{
    protected static ?string $model = OnlineExam::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Online Exam';

    protected static ?string $navigationLabel = 'Online Exam';

    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Add Exam')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->required(),
                        TextInput::make('percentage')
                            ->label('Percentage')
                            ->numeric()
                            ->required(),
                        DatePicker::make('date')
                            ->label('Date')
                            ->required(),
                        TimePicker::make('start_time')
                            ->label('Start Time')
                            ->required(),
                        TimePicker::make('end_time')
                            ->label('End Time')
                            ->required(),
                        DateTimePicker::make('end_date_time')
                            ->label('End Date Time'),


                        Textarea::make('instruction')
                            ->label('Instruction')->columnSpanFull(),

                        Section::make()->schema([
                            Radio::make('is_published')
                                ->label('Published')
                                ->options([
                                    1 => 'Yes',
                                    0 => 'No',
                                ])
                                ->default(0),
                            Radio::make('is_taken')
                                ->label('Taken')
                                ->options([
                                    1 => 'Yes',
                                    0 => 'No',
                                ])
                                ->default(0),
                            Radio::make('is_closed')
                                ->label('Closed')
                                ->options([
                                    1 => 'Yes',
                                    0 => 'No',
                                ])
                                ->default(0),
                            Radio::make('is_waiting')
                                ->label('Waiting')
                                ->options([
                                    1 => 'Yes',
                                    0 => 'No',
                                ])
                                ->default(0),
                            Radio::make('is_running')
                                ->label('Running')
                                ->options([
                                    1 => 'Yes',
                                    0 => 'No',
                                ])
                                ->default(0),
                            Radio::make('auto_mark')
                                ->label('Auto Mark')
                                ->options([
                                    1 => 'Yes',
                                    0 => 'No',
                                ])
                                ->default(0),
                            Radio::make('status')
                                ->options([
                                    '1' => 'Active',
                                    '0' => 'Inactive',
                                ])->default(1),
                        ])->columns(2)

                    ])->columns(2)
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Title'),
                TextColumn::make('percentage')
                    ->searchable()->sortable()
                    ->label('Percentage'),
                TextColumn::make('date')
                    ->label('Date')->searchable()->sortable()->listWithLineBreaks()->wrap(),
                TextColumn::make('start_time')
                    ->label('Start Time')->searchable()->sortable()->listWithLineBreaks()->wrap(),
                TextColumn::make('end_time')
                    ->label('End Time')->searchable()->sortable()->listWithLineBreaks()->wrap(),
                TextColumn::make('end_date_time')
                    ->label('End Date Time')->searchable()->sortable()->listWithLineBreaks()->wrap(),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->icon(fn($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn($state) => $state ? 'success' : 'danger')->searchable()->sortable(),

                IconColumn::make('is_taken')
                    ->label('Taken')
                    ->icon(fn($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn($state) => $state ? 'success' : 'danger')->searchable()->sortable(),

                IconColumn::make('is_closed')
                    ->label('Closed')
                    ->icon(fn($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn($state) => $state ? 'success' : 'danger')->searchable()->sortable(),

                IconColumn::make('is_waiting')
                    ->label('Waiting')
                    ->icon(fn($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn($state) => $state ? 'success' : 'danger')->searchable()->sortable(),
                IconColumn::make('is_running')
                    ->label('Running')
                    ->icon(fn($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn($state) => $state ? 'success' : 'danger')->searchable()->sortable(),
                IconColumn::make('auto_mark')
                    ->label('Auto mark')
                    ->icon(fn($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn($state) => $state ? 'success' : 'danger')->searchable()->sortable(),

                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => match ($state) {
                        1 => 'Active',
                        0 => 'Inactive',
                    })
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        1 => 'success',
                        0 => 'danger',
                    })->searchable()->sortable(),
                TextColumn::make('instruction')
                    ->label('Instruction')
                    ->searchable()->sortable()->listWithLineBreaks()->wrap()
                    ->limit(50),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ])
                    ->label('Status')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListOnlineExams::route('/'),
            'create' => Pages\CreateOnlineExam::route('/create'),
            'edit' => Pages\EditOnlineExam::route('/{record}/edit'),
        ];
    }
}
