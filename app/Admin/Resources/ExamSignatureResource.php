<?php

namespace App\Admin\Resources;

use App\Admin\Resources\ExamSignatureResource\Pages;
use App\Admin\Resources\ExamSignatureResource\RelationManagers;
use App\Models\ExamSignature;
use App\Models\ExamSignatures;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExamSignatureResource extends Resource
{
    protected static ?string $model = ExamSignature::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Exam Setup';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Exam Signature';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Exam Signature')
                    ->schema([
                        TextInput::make('title')->required(),

                        Select::make('batch_id')->label('Batch')->relationship('batch', 'name')->preload()->native(false)->searchable(),
                        FileUpload::make('signature')
                            ->label('Signature')
                            ->directory('exam-signatures')
                            ->image()
                            ->columnSpanFull()->required(),
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
                TextColumn::make('id')->label('Sl')->rowIndex()->searchable()->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('batch.name')->searchable()->sortable(),
                ImageColumn::make('signature')
                    ->getStateUsing(fn($record) => $record->signature)
                    ->url(fn($record) => $record->signature
                        ? asset('storage/' . $record->signature)
                        : null),
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
            'index' => Pages\ListExamSignatures::route('/'),
            'create' => Pages\CreateExamSignature::route('/create'),
            'edit' => Pages\EditExamSignature::route('/{record}/edit'),
        ];
    }
}
