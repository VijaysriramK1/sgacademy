<?php

namespace App\Admin\Resources;

use App\Admin\Resources\BatchProgramResource\Pages;
use App\Filament\Admin\Resources\BatchProgramsResource\RelationManagers;
use App\Models\BatchPrograms;
use App\Models\Section as ModelsSection;
use App\Models\Sections;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BatchProgramResource extends Resource
{
    protected static ?string $model = BatchPrograms::class;

    protected static ?string $navigationGroup = 'Batches';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Batch Programs')
                ->schema([
                    Select::make('batch_id')
                    ->label('Batch')
                    ->relationship('batch', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(),
                    Select::make('program_id')
                    ->label('Program')
                    ->relationship('program', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(),
                    Select::make('section_id')
                    ->label('Section')
                    ->options(
                        ModelsSection::query()->pluck('name', 'id')->toArray()
                    )
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(),
                    // Select::make('institution_id')
                    // ->relationship('institution', 'name')
                    // ->searchable()
                    // ->preload()
                    // ->native(false)
                    // ->required(),
                    Radio::make('status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])

                    ->default('1'),

                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->rowIndex(),
                TextColumn::make('batch.name')->searchable(),
                TextColumn::make('program.name')->searchable(),
                TextColumn::make('section.name')->searchable(),
                TextColumn::make('status')
                ->formatStateUsing(fn($state) => match ($state) {
                    1 => 'Active',
                    0 => 'Inactive',
                })
                ->badge()
                ->color(fn($state) => match ($state) {
                    1 => 'success',
                    0 => 'danger',
                })
                ->searchable(),
                // TextColumn::make('institution.name')->searchable(),

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
            'index' => Pages\ListBatchPrograms::route('/'),
            'create' => Pages\CreateBatchProgram::route('/create'),
            'edit' => Pages\EditBatchProgram::route('/{record}/edit'),
        ];
    }
}
