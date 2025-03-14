<?php

namespace App\Admin\Resources;

use App\Admin\Resources\ExamTypeResource\Pages;
use App\Admin\Resources\ExamTypeResource\RelationManagers;
use App\Models\ExamType;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpParser\Node\Stmt\Label;

class ExamTypeResource extends Resource
{
    protected static ?string $model = ExamType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Examination';

    protected static ?string $navigationLabel = 'Exam Type';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Exam type')
                ->schema([
                    TextInput::make('title')
                        ->label('Exam Name')
                        ->required(),
                        Radio::make('status')
                        ->options([
                         '1' => 'Active',
                         '0' => 'Inactive',
                        ])->default(1),
                ]),
                Section::make('Mark')
                ->schema([
                    Toggle::make('is_average')
                        ->label('Average')->live(),
                    
                    Toggle::make('percentage')
                        ->label('Percentage')->live(),

                        
                    
                    TextInput::make('average_mark')
                        ->label('Average Mark')
                        ->visible(fn ($get) => $get('is_average')),
                    
                    TextInput::make('percentage_value')
                        ->label('Percentage')
                        ->visible(fn ($get) => $get('percentage')),

                       
                        
                ])->columns(2)
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sl')->rowIndex()->searchable()->sortable(),
                TextColumn::make('title')->searchable()->sortable()->label('Title'),
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
                
                IconColumn::make('is_average')
                ->label('Average')
                ->icon(fn ($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                ->color(fn ($state) => $state ? 'success' : 'danger')->searchable()->sortable(),

                TextColumn::make('average_mark')->label('Average Mark')->searchable()->sortable(),

                IconColumn::make('percentage')
                ->label('Percentage')
                ->icon(fn ($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                ->color(fn ($state) => $state ? 'success' : 'danger'),

                TextColumn::make('percantage')->label('Percentage')->searchable()->sortable(),



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
            'index' => Pages\ListExamTypes::route('/'),
            'create' => Pages\CreateExamType::route('/create'),
            'edit' => Pages\EditExamType::route('/{record}/edit'),
        
        ];
    }
}
