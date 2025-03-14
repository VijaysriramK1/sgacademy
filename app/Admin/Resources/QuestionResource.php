<?php

namespace App\Admin\Resources;

use App\Admin\Resources\QuestionResource\Pages;
use App\Admin\Resources\QuestionResource\RelationManagers;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Online Exam';

    protected static ?string $navigationLabel = 'Question';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Add Question')
                    ->schema([
                        TextInput::make('title')->label('Title')->columnSpanFull(),
                        Select::make('online_exam_id')->relationship('online_exam', 'title')->searchable()->native(false)->preload(),
                        Select::make('type')
                        ->label('Question Type')
                        ->options([
                            'M' => 'Multiple Choice (MC)',
                            'T' => 'True or False (T/F)',
                            'F' => 'Fill in the Blanks (FIB)',
                        ])
                        ->required()
                        ->searchable()
                        ->native(false)
                        ->preload(),
                        TextInput::make('mark')->label('Mark')->numeric(),
                        TextInput::make('error_mark')->label('Error Mark')->numeric(),
                        Textarea::make('suitable_words')->label('Suitable Words')->columnSpanFull(),
                        Section::make()->schema([
                            Radio::make('is_true')
                                ->options([
                                    '1' => 'yes',
                                    '0' => 'no',
                                ])->default(1)->label('Is True'),
                            Radio::make('status')
                                ->options([
                                    '1' => 'Active',
                                    '0' => 'Inactive',
                                ])->default(1),
                        ])->columns(2)
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('online_exam.title')->searchable()->sortable(),
                TextColumn::make('type')
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'M' => 'Multiple Choice (MC)',
                    'T' => 'True or False (T/F)',
                    'F' => 'Fill in the Blanks (FIB)',
                    default => $state,
                })
                ->color(fn (string $state): string => match ($state) {
                    'M' => 'success',
                    'T' => 'warning',
                    'F' => 'primary',
                    default => 'gray'
                })
                ->searchable()
                ->sortable(),
                TextColumn::make('mark')->searchable()->sortable(),
                TextColumn::make('error_mark')->searchable()->sortable(),
                TextColumn::make('suitable_words')->searchable()->sortable()->listWithLineBreaks()->wrap(),
                
                IconColumn::make('is_true')
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
                SelectFilter::make('type')
                ->label('Question Type')
                ->options([
                    'M' => 'Multiple Choice (MC)',
                    'T' => 'True or False (T/F)',
                    'F' => 'Fill in the Blanks (FIB)',
                ])
                ->searchable()
                ->preload()
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
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
