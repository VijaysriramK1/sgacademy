<?php

namespace App\Admin\Resources;

use App\Admin\Resources\ProgramResource\Pages;
use App\Admin\Resources\ProgramResource\RelationManagers;
use App\Models\Program;
use App\Models\Programs;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Batches';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Program';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Program')
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('program_code')->label('Branch Code'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->rowIndex(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('program_code')->label('Branch Code')->searchable(),
                // TextColumn::make('institution.name')->searchable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
