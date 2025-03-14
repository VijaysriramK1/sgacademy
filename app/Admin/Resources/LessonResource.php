<?php

namespace App\Admin\Resources;

use App\Admin\Resources\LessonResource\Pages;

use App\Models\Courses;
use App\Models\lesson;

use Filament\Tables\Actions\ActionGroup;

use Filament\Tables\Actions\ViewAction;
use Filament\Forms;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class LessonResource extends Resource
{
    protected static ?string $model = lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationGroup = 'Batches';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Lesson')
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        TextInput::make('content')
                            ->required(),
                        Select::make('course_id')
                            ->options(
                                Courses::query()->pluck('name', 'id')->toArray()
                            )
                            ->label('Course')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false),
                        DateTimePicker::make('date')
                            ->label('Start Date')
                            ->prefixIcon('heroicon-o-calendar')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sl')->rowIndex(),
                TextColumn::make('title')->label('Title'),
                TextColumn::make('content')->label('Content'),
                TextColumn::make('course.name')->label('Course'),
            ])
            ->filters([])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                    ->icon('heroicon-o-plus-circle')
                    ->label('Add Topic'),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
            'view' => Pages\ViewLesson::route('/{record}'),
          
            
        ];
    }
}
