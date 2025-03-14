<?php

namespace App\Admin\Resources;

use App\Admin\Resources\StudentIdCardResource\Pages;
use App\Admin\Resources\StudentIdCardResource\RelationManagers;
use App\Models\StudentIdCard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentIdCardResource extends Resource
{
    protected static ?string $model = StudentIdCard::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('role_id')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('student_id')
                    ->numeric(),
                Forms\Components\TextInput::make('staff_id')
                    ->numeric(),
                Forms\Components\TextInput::make('layout')
                    ->maxLength(255),
                Forms\Components\TextInput::make('profile_layout')
                    ->maxLength(255),
                Forms\Components\TextInput::make('logo')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('background_image')
                    ->image(),
                Forms\Components\TextInput::make('pageLayoutWidth')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pageLayoutHeight')
                    ->maxLength(255),
                Forms\Components\TextInput::make('admission_no')
                    ->required()
                    ->maxLength(255)
                    ->default(0),
                Forms\Components\TextInput::make('student_name')
                    ->required()
                    ->maxLength(255)
                    ->default(0),
                Forms\Components\TextInput::make('program')
                    ->required()
                    ->maxLength(255)
                    ->default(0),
                Forms\Components\TextInput::make('father_name')
                    ->required()
                    ->maxLength(255)
                    ->default(0),
                Forms\Components\TextInput::make('mother_name')
                    ->required()
                    ->maxLength(255)
                    ->default(0),
                Forms\Components\TextInput::make('student_address')
                    ->required()
                    ->maxLength(255)
                    ->default(0),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->required()
                    ->maxLength(255)
                    ->default(0),
                Forms\Components\TextInput::make('dob')
                    ->required()
                    ->maxLength(255)
                    ->default(0),
                Forms\Components\TextInput::make('blood')
                    ->required()
                    ->maxLength(255)
                    ->default(0),
                Forms\Components\TextInput::make('signature')
                    ->maxLength(255),
                Forms\Components\TextInput::make('institution_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('staff_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('layout')
                    ->searchable(),
                Tables\Columns\TextColumn::make('profile_layout')
                    ->searchable(),
                Tables\Columns\TextColumn::make('logo')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('background_image'),
                Tables\Columns\TextColumn::make('pageLayoutWidth')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pageLayoutHeight')
                    ->searchable(),
                Tables\Columns\TextColumn::make('admission_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('student_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('program')
                    ->searchable(),
                Tables\Columns\TextColumn::make('father_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mother_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('student_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dob')
                    ->searchable(),
                Tables\Columns\TextColumn::make('blood')
                    ->searchable(),
                Tables\Columns\TextColumn::make('signature')
                    ->searchable(),
                Tables\Columns\TextColumn::make('institution_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListStudentIdCards::route('/'),
            'create' => Pages\CreateStudentIdCard::route('/create'),
            'edit' => Pages\EditStudentIdCard::route('/{record}/edit'),
        ];
    }
}
