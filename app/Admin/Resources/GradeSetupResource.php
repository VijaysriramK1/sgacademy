<?php

namespace App\Admin\Resources;

use App\Admin\Resources\GradeSetupResource\Pages;
use App\Admin\Resources\GradeSetupResource\RelationManagers;
use App\Models\GradeSetup;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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

class GradeSetupResource extends Resource
{
    protected static ?string $model = GradeSetup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Examination';

    protected static ?string $navigationLabel = 'Grade Setup';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Grade Setup')
                ->schema([
                    Select::make('grade_id')->label('Grade')->relationship('grade','name')->searchable()->preload()->native(false),
                    TextInput::make('name')->label('Name')->required(),
                    TextInput::make('gpa')->label('Gpa')->required(),
                    TextInput::make('min_mark')->label('Min Mark')->required(),
                    TextInput::make('max_mark')->label('Max Mark')->required(),
                    TextInput::make('min_percent')->label('Min Percent')->required(),
                    TextInput::make('max_percent')->label('Max Percent')->required(),
                   
                    Textarea::make('description')->label('Description')->required()->columnSpanFull(),
                    Radio::make('status')
                    ->options([
                     '1' => 'Active',
                     '0' => 'Inactive',
                    ])->default(1),

                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('grade.name')->label('Grade')->searchable()->sortable(),
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('gpa')->label('Gpa')->searchable()->sortable(),
                TextColumn::make('min_mark')->label('Min Mark')->searchable()->sortable(),
                TextColumn::make('max_mark')->label('Max Mark')->searchable()->sortable(),
                TextColumn::make('min_percent')->label('Min Percent')->searchable()->sortable(),
                TextColumn::make('max_percent')->label('Max Percent')->searchable()->sortable(),
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
            'index' => Pages\ListGradeSetups::route('/'),
            'create' => Pages\CreateGradeSetup::route('/create'),
            'edit' => Pages\EditGradeSetup::route('/{record}/edit'),
        ];
    }
}
