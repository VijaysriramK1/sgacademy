<?php

namespace App\Admin\Resources;

use App\Admin\Resources\GradeResource\Pages;
use App\Admin\Resources\GradeResource\RelationManagers;
use App\Models\Grade;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Examination';

    protected static ?string $navigationLabel = 'Grade';

    protected static ?int $navigationSort = 4;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Add Grade')
                ->schema([
                    TextInput::make('name')->label('Name')->required(),
                    Textarea::make('description')->label('Description'),
                    Radio::make('status')
                    ->options([
                     '1' => 'Active',
                     '0' => 'Inactive',
                    ])->default(1),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('sl')->rowIndex(),
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('description')->label('Description')->searchable()->sortable()->listWithLineBreaks()->wrap(),
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
            'index' => Pages\ListGrades::route('/'),
            // 'create' => Pages\CreateGrade::route('/create'),
            // 'edit' => Pages\EditGrade::route('/{record}/edit'),
        ];
    }
}
