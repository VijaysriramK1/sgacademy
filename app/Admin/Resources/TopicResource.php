<?php

namespace App\Admin\Resources;

use App\Admin\Resources\LessonResource\Pages\ViewSubtopic;
use App\Admin\Resources\TopicResource\Pages;
use App\Admin\Resources\TopicResource\RelationManagers;
use App\Models\Topic;
use App\Models\Topics;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TopicResource extends Resource
{
    protected static ?string $model = Topic::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Batches';
    
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Topic')
                    ->schema([
                        Select::make('lesson_id')
                            ->relationship('lesson', 'title')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('title')
                            ->required(),
                        TextInput::make('content')
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sl')->rowIndex(),
                TextColumn::make('lesson.title')->searchable(),
                TextColumn::make('title')->searchable(),
                TextColumn::make('content')->searchable(),
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
            'index' => Pages\ListTopics::route('/'),
            // 'create' => Pages\CreateTopic::route('/create'),
            // 'edit' => Pages\EditTopic::route('/{record}/edit'),
            'view-subtopic' =>ViewSubtopic::route('/{record}')
        ];
    }
}
