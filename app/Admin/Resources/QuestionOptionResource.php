<?php

namespace App\Admin\Resources;

use App\Admin\Resources\QuestionOptionResource\Pages;
use App\Admin\Resources\QuestionOptionResource\RelationManagers;
use App\Models\QuestionOption;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionOptionResource extends Resource
{
    protected static ?string $model = QuestionOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Online Exam';

    protected static ?string $navigationLabel = 'Question Option';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Question Options')->schema([
                    TextInput::make('name')->label('Name'),
                    Select::make('question_id')->relationship('question','title')->searchable()->preload()->native(false),
                    Section::make()->schema([
                    Radio::make('is_answer')
                                ->label('Is Answer')
                                ->options([
                                    1 => 'Yes',
                                    0 => 'No',
                                ])
                                ->default(0),
                                Radio::make('status')
                                ->options([
                                    '1' => 'Active',
                                    '0' => 'Inactive',
                                ])->default(1),
                                ])
                                
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('question.title')->searchable()->sortable(),
                IconColumn::make('is_answer')
                ->label('True')
                ->icon(fn($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                ->color(fn($state) => $state ? 'success' : 'danger')->searchable()->sortable(),
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
                ->label('Status'),
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
            'index' => Pages\ListQuestionOptions::route('/'),
            // 'create' => Pages\CreateQuestionOption::route('/create'),
            // 'edit' => Pages\EditQuestionOption::route('/{record}/edit'),
        ];
    }
}
