<?php

namespace App\Admin\Resources;

use App\Admin\Resources\StudentcategoryResource\Pages;
use App\Filament\Admin\Resources\StudentcategoryResource\RelationManagers;
use App\Models\Studentcategory;
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

class StudentcategoryResource extends Resource
{
    protected static ?string $model =  Studentcategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Student Info';

    protected static ?string $navigationLabel = 'Student Category';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Add Category')
                ->schema([
                TextInput::make('name')->label('Name'),
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
                TextColumn::make('id')->rowIndex()->label('Sl')->searchable(),
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
                //
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
            'index' => Pages\ListStudentcategories::route('/'),
            'create' => Pages\CreateStudentcategory::route('/create'),
            'edit' => Pages\EditStudentcategory::route('/{record}/edit'),
        ];
    }
}
