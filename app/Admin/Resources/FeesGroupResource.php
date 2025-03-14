<?php

namespace App\Admin\Resources;

use App\Admin\Resources\FeesGroupResource\Pages;
use App\Admin\Resources\FeesGroupResource\RelationManagers;
use App\Models\FeesGroup;
use Filament\Forms;
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

class FeesGroupResource extends Resource
{
    protected static ?string $model = FeesGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static ?string $navigationGroup = 'Fees';

    public static ?string $navigationLabel = 'Fees Group';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Fees Group')
                ->schema([
                TextInput::make('name')
                ->label('Name'),
                Textarea::make('description')
                ->label('Description'),
                Select::make('status')
                ->label('Status')
                ->options([
                    1 => 'Active',
                    0 => 'Inactive',
                ])
                ->default(1)
                ->searchable()
                ->preload()
                ->native(false),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('description')->label('Description')->searchable()->sortable()->wrap()->listWithLineBreaks(),
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
            'index' => Pages\ListFeesGroups::route('/'),
            'create' => Pages\CreateFeesGroup::route('/create'),
            'edit' => Pages\EditFeesGroup::route('/{record}/edit'),
        ];
    }
}
