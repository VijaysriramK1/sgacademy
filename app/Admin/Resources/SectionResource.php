<?php

namespace App\Admin\Resources;

use App\Admin\Resources\SectionResource\Pages;
use App\Models\Section;
use App\Models\Section as ModelsSections;
use Filament\Forms\Components\Section as Sections;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class SectionResource extends Resource
{
    protected static ?string $model = Section::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Batches';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Section';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Sections::make('Branch Information')
                ->schema([
                        TextInput::make('name')
                            ->required(),
                            // Select::make('institution_id')
                            // ->label('Institution')
                            // ->relationship('institution', 'name')
                            // ->required()
                            // ->searchable()
                            // ->preload()
                            // ->native(false)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('sl')->rowIndex(),
                TextColumn::make('name'),
                // TextColumn::make('institution.name'),
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
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
