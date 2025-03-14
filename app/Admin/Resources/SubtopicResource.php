<?php

namespace App\Admin\Resources;

use App\Admin\Resources\SubtopicResource\Pages;
use App\Admin\Resources\SubtopicResource\RelationManagers;
use App\Models\Courses;
use App\Models\Program;
use App\Models\Section as ModelsSection;
use App\Models\Subtopic;
use App\Models\Topic;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
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

class SubtopicResource extends Resource
{
    protected static ?string $model = Subtopic::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Batches';

    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                    TextInput::make('title')->label('Title')->columnSpanFull(),
                    TextInput::make('max_marks')->label('Max Mark')->numeric(),
                    TextInput::make('avg_marks')->label('Avg Mark')->numeric(),
                    FileUpload::make('image')->label('Image')->columnSpanFull(),
                    Select::make('program_id')->options(  Program::query()->pluck('name', 'id')->toArray()),
                    Select::make('section_id')->options(  ModelsSection::query()->pluck('name', 'id')->toArray()),
                    Select::make('course_id')->options(  Courses::query()->pluck('name', 'id')->toArray()),
                    Select::make('topic_id')->options(  Topic::query()->pluck('title', 'id')->toArray()),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('max_marks')->searchable()->sortable(),
                TextColumn::make('avg_marks')->searchable()->sortable(),
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
            'index' => Pages\ListSubtopics::route('/'),
            'create' => Pages\CreateSubtopic::route('/create'),
            'edit' => Pages\EditSubtopic::route('/{record}/edit'),
        ];
    }
}
