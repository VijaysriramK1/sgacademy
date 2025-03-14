<?php

namespace App\Admin\Resources\LessonResource\RelationManagers;

use App\Models\Courses;
use App\Models\Program;
use App\Models\Section as ModelsSection;
use App\Models\Topic;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ActionGroup;

class SubTopicRelationManager extends RelationManager
{
    protected static string $relationship = 'SubTopic';

    protected static bool $shouldRegisterNavigation = true;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                    TextInput::make('title')->label('Title')->columnSpanFull(),
                    TextInput::make('max_marks')->label('Max Mark')->numeric(),
                    TextInput::make('avg_marks')->label('Avg Mark')->numeric(),
                    FileUpload::make('image')->label('Image')->columnSpanFull(),
                  
                ])->columns(2)
            ]);
    }


    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sl')->rowIndex(),
                TextColumn::make('title')->label('Title')->searchable()->sortable(),
                TextColumn::make('max_marks')->label('Max Mark')->searchable()->sortable(),
                TextColumn::make('avg_marks')->label('Avg Mark')->searchable()->sortable(),

            ])
            ->headerActions([
                CreateAction::make()
                    ->visible(true)
                    ->icon('heroicon-m-plus')
                    ->label('Add SubTopic')
                    ->authorize(true),
            ])
            ->actions([
                ActionGroup::make([
                   
                    EditAction::make()
                        ->visible(true)
                        ->authorize(true),
                    DeleteAction::make()
                        ->visible(true)
                        ->authorize(true),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    protected function canCreate(): bool
    {
        return true;
    }

    protected function canEdit(mixed $record): bool
    {
        return true;
    }

    protected function canDelete(mixed $record): bool
    {
        return true;
    }

}
