<?php

namespace App\Admin\Resources;

use App\Admin\Resources\FeesTypeResource\Pages;
use App\Admin\Resources\FeesTypeResource\RelationManagers;
use App\Models\FeesType;
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

class FeesTypeResource extends Resource
{
    protected static ?string $model = FeesType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static ?string $navigationGroup = 'Fees';

    public static ?string $navigationLabel = 'Fees Type';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        TextInput::make('name')->label('Name')->columnSpanFull(),

                        Select::make('type')
                            ->label('Fees Type')
                            ->options([
                                'admission' => 'Admission Fee',
                                'tuition' => 'Tuition Fee',
                                'exam' => 'Exam Fee',
                                'library' => 'Library Fee',
                                'transport' => 'Transport Fee',
                            ])
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('fee_group_id')
                            ->label('Fees Group')
                            ->relationship('feesgroup', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false),
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
                        Textarea::make('description')->label('description')->columnSpanFull(),



                    ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('feesgroup.name')->label('Fees Group')->searchable()->sortable(),
                TextColumn::make('type')
                    ->label('Type')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'admission' => 'danger',   // Red
                        'tuition' => 'primary',    // Blue
                        'exam' => 'success',       // Green
                        'library' => 'purple',     // Purple
                        'transport' => 'warning',  // Yellow
                        default => 'gray',         // Default color
                    }),
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
                    ->label('Status'),
                SelectFilter::make('type')
                    ->label('Fees Type')
                    ->options([
                        'admission' => 'Admission Fee',
                        'tuition' => 'Tuition Fee',
                        'exam' => 'Exam Fee',
                        'library' => 'Library Fee',
                        'transport' => 'Transport Fee',
                    ])
                    ->searchable(),
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
            'index' => Pages\ListFeesTypes::route('/'),
            'create' => Pages\CreateFeesType::route('/create'),
            'edit' => Pages\EditFeesType::route('/{record}/edit'),
        ];
    }
}
