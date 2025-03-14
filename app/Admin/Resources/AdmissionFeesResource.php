<?php

namespace App\Admin\Resources;

use App\Admin\Resources\AdmissionFeesResource\Pages;
use App\Admin\Resources\AdmissionFeesResource\RelationManagers;
use App\Models\AdmissionFees;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdmissionFeesResource extends Resource
{
    protected static ?string $model = AdmissionFees::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static ?string $navigationGroup = 'Fees';

    public static ?string $navigationLabel = 'Admisssion Fees';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                    Select::make('batch_id')
                    ->label('Batch')
                    ->relationship('batch', 'name')
                    ->searchable()
                    ->preload()
                    ->native(true)
                    ,

                    Select::make('program_id')
                    ->label('Program')
                    ->relationship('program', 'name')
                    ->searchable()
                    ->preload()
                    ->native(true),

                    Select::make('fee_type_id')
                    ->label('Fees Type')
                    ->relationship(
                        'feestype', 
                        'name', 
                        fn ($query) => $query->where('type', 'admission')->where('status', 1)
                    )
                    ->searchable()
                    ->preload()
                    ->native(true),

                    TextInput::make('amount')->label('Amount')->numeric()
                
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sl')->rowIndex()->searchable()->sortable(),
                TextColumn::make('batch.name')->label('Batch')->searchable()->sortable(),
                TextColumn::make('program.name')->label('Program')->searchable()->sortable(),
                TextColumn::make('feestype.name')->label('Fees Type')->searchable()->sortable(),
                TextColumn::make('amount')->label('Amount')->searchable()->sortable()->badge()

            ])
            ->filters([
                
            ])
            ->actions([
                ActionGroup::make([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
                ])

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
            'index' => Pages\ListAdmissionFees::route('/'),
            'create' => Pages\CreateAdmissionFees::route('/create'),
            'edit' => Pages\EditAdmissionFees::route('/{record}/edit'),
        ];
    }
}
