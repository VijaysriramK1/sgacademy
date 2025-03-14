<?php

namespace App\Admin\Resources;

use App\Admin\Resources\OnlineAssignProgramResource\Pages;
use App\Admin\Resources\OnlineAssignProgramResource\RelationManagers;
use App\Models\OnlineAssignProgram;
use App\Models\OnlineExamProgram;
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

class OnlineAssignProgramResource extends Resource
{
    protected static ?string $model = OnlineExamProgram::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Online Exam';

    protected static ?string $navigationLabel = 'Online Assign Program';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Assign Program')
                ->schema([
                    Select::make('batch_id')->relationship('Batch','name')->searchable()->preload()->native(false)->required(),
                    Select::make('program_id')->relationship('program','name')->searchable()->preload()->native(false),
                    Select::make('semester_id')->relationship('section','name')->searchable()->preload()->native(false)->required(),
                    Select::make('section_id')->relationship('semester','name')->searchable()->preload()->native(false),
                    Radio::make('status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])->default(1),

                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Batch.name')->searchable()->sortable(),
                TextColumn::make('program.name')->searchable()->sortable(),
                TextColumn::make('section.name')->searchable()->sortable(),
                TextColumn::make('semester.name')->searchable()->sortable(),
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
            'index' => Pages\ListOnlineAssignPrograms::route('/'),
            'create' => Pages\CreateOnlineAssignProgram::route('/create'),
            'edit' => Pages\EditOnlineAssignProgram::route('/{record}/edit'),
        ];
    }
}
