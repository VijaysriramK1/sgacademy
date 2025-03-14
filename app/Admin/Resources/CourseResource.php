<?php

namespace App\Admin\Resources;

use App\Admin\Resources\CourseResource\Pages;
use App\Admin\Resources\CourseResource\RelationManagers;
use App\Models\Courses;
use Filament\Forms;
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

class CourseResource extends Resource
{
    protected static ?string $model = Courses::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationGroup = 'Batches';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Add Course')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('course_code')
                            ->required()
                            ->columnSpanFull(),
                        // Select::make('institution_id')
                        //     ->relationship('institution', 'name')
                        //     ->required()
                        //     ->preload()
                        //     ->native(false)
                        //     ->searchable()
                        //     ->columnSpanFull(),

                Radio::make('course_type')
                    ->options([
                        'theory' => 'Theory',
                        'practical' => 'Practical',
                    ])
                    ->inline()
                    ->required()
                    ->default('theory'),

                Radio::make('status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->inline()
                    ->required()
                    ->default(1),

                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sl')->rowIndex(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('course_code')
                    ->searchable(),
                TextColumn::make('course_type')
                    ->searchable(),
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
