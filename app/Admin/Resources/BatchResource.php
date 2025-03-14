<?php

namespace App\Admin\Resources;

use App\Admin\Resources\BatchResource\Pages;
use App\Filament\Admin\Resources\BatchesResource\RelationManagers;
use App\Models\Batch;
use App\Models\Batches;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BatchResource extends Resource
{
    protected static ?string $model = Batch::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Batches';

    protected static ?string $navigationLabel = 'Batch';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Branch Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Batch')
                            ->required(),
                        TextInput::make('year')
                            ->label('Year')
                            ->required()
                            ->numeric(),
                        DateTimePicker::make('start_date')
                            ->label('Start Date')
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('End Date')
                            ->required(),



                            Radio::make('status')
                            ->options([
                                1 => 'Active',
                                0 => 'Deactivity',
                            ])

                            ->default(1)
                            ->columnSpanFull(),
                    ])->columns(2)


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->rowIndex(),
                TextColumn::make('name')
                    ->label('Batch')
                    ->searchable(),
                TextColumn::make('year')
                    ->label('Year')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->searchable(),
                TextColumn::make('end_date')
                    ->label('End Date')
                    ->searchable(),

                TextColumn::make('status')

                    ->formatStateUsing(fn($state) => match ($state) {
                        1 => 'Activity',
                        0 => 'Deactivity',
                    })
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        1 => 'success',
                        0 => 'danger',
                    })
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        1 => 'Activity',
                        0 => 'Deactivity',
                    ])
                    ->label('Status')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
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
            'index' => Pages\ListBatchs::route('/'),
            'create' => Pages\CreateBatch::route('/create'),
            'edit' => Pages\EditBatch::route('/{record}/edit'),
        ];
    }
}
