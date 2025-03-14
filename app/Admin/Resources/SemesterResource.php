<?php

namespace App\Admin\Resources;

use App\Admin\Resources\SemesterResource\Pages;
use App\Admin\Resources\SemesterResource\RelationManagers;
use App\Models\Semester;
use App\Models\Semesters;
use Faker\Provider\ar_EG\Text;
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

class SemesterResource extends Resource
{
    protected static ?string $model = Semester::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Batches';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Semester';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Semesters')
                ->schema([
                    TextInput::make('name')
                    ->label('Name')
                    ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->rowIndex(),
                TextColumn::make('name')
                ->label('Name')
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                SelectFilter::make('year')
                ->options(
                   Semester::select('year')
                    ->groupBy('year')
                    ->orderBy('year', 'desc')
                    ->get()
                    ->pluck('year', 'year')
                )
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

                    Tables\Actions\DeleteBulkAction::make()->label('Delete'),

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
            'index' => Pages\ListSemesters::route('/'),
            'create' => Pages\CreateSemester::route('/create'),
            'edit' => Pages\EditSemester::route('/{record}/edit'),
        ];
    }
}
