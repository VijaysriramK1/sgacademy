<?php

namespace App\Admin\Resources;

use App\Admin\Resources\StudentgroupResource\Pages;
use App\Filament\Admin\Resources\StudentgroupResource\RelationManagers;
use App\Models\Program;
use App\Models\Studentgroup;
use Filament\Forms;
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

class StudentgroupResource extends Resource
{
    protected static ?string $model =  Studentgroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Student Info';

    protected static ?string $navigationLabel = 'Student Group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Add Group')
                ->schema([
                TextInput::make('name')->label('group'),
                Select::make('status')
                ->options([
                    1 => 'Active',
                    0 => 'Inactive'
                ])
                ->default(1)
                ->searchable()
                ->preload()
                ->native(false)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sl')->rowIndex(),
                TextColumn::make('name')->searchable()->sortable(),
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
                ->searchable()
                ->sortable(),
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
            'index' => Pages\ListStudentgroups::route('/'),
            'create' => Pages\CreateStudentgroup::route('/create'),
            'edit' => Pages\EditStudentgroup::route('/{record}/edit'),
        ];
    }
}
