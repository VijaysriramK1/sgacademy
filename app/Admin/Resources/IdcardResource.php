<?php

namespace App\Admin\Resources;

use App\Admin\Resources\IdcardResource\Pages;
use App\Filament\Admin\Resources\IdcardResource\RelationManagers;
use App\Models\IdCards;
use App\Models\StudentIdCard;
use Faker\Core\File;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function Laravel\Prompts\select;

class IdcardResource extends Resource
{
    protected static ?string $model = StudentIdCard::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Student Info';

    protected static ?string $navigationLabel = 'Student ID Card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Add Id Card')
                    ->schema([
                        Select::make('role_id')
                            ->label('User Role')
                            ->options([
                                'student' => 'Student',
                                'staff' => 'Staff',
                            ])->required()->searchable()->preload()->native(false)->live(),
                            Select::make('student_id')
                            ->label('Student')
                           ->relationship('student', 'first_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->live()
                            ->visible(fn($get) => $get('role_id') === 'student'),
                        Select::make('staff_id')
                            ->label('Staff')
                            ->options([
                                'Dhinesh' => 'Dhinesh',
                                'Suresh' => 'Suresh',
                            ])
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->live()
                            ->visible(fn($get) => $get('role_id') === 'staff'),

                        Select::make('layout')
                            ->label('ID Card Layout')
                            ->options([
                                'horizontal' => 'Horizontal',
                                'vertical' => 'Vertical',
                            ])
                            ->live()
                            ->required()
                            ->default('vertical'),

                        Select::make('profile_layout')
                            ->label('Profile Layout')
                            ->options([
                                'square' => 'Square',
                                'circle' => 'Circle',
                            ])
                            ->live(),

                        FileUpload::make('logo')
                            ->label('Logo')
                            ->live()
                            ->image()
                            ->disk('public')
                            ->directory('logos')
                            ->visibility('public'),

                        FileUpload::make('background_image')
                            ->label('Blackground image')
                            ->live(),

                        FileUpload::make('signature')
                            ->label('Signature')
                            ->live(),

                        TextInput::make('pageLayoutWidth')
                            ->label('Page Layout Width')
                            ->numeric()
                            ->helperText('Enter a value between 50 and 200')
                            ->minValue(50)
                            ->maxValue(200)
                            ->live()
                            ->afterStateUpdated(function ($set, $state) {
                                if ($state > 200) {
                                    $set('pageLayoutWidth', 200);
                                    return;
                                }
                                $columnSpan = $state > 100 ? 2 : 1;
                                $set('preview_column_span', $columnSpan);
                            }),


                        TextInput::make('pageLayoutHeight')
                            ->label('Page Layout Height')
                            ->numeric()
                            ->minValue(50)
                            ->maxValue(300)
                            ->live(),

                        select::make('institution_id')
                            ->label('Institution')
                            ->relationship('institution', 'name')
                            ->searchable(),
                        Section::make('Visible Fields')
                            ->columns(2)
                            ->schema([
                                Radio::make('admission_no')
                                    ->label('Admission No ')
                                    ->boolean()
                                    ->inline()
                                    ->live()
                                    ->default(1),

                                Radio::make('student_name')
                                    ->label('Name')
                                    ->boolean()
                                    ->inline()
                                    ->live()->default(1),

                                Radio::make('program')
                                    ->label('Class')
                                    ->boolean()
                                    ->inline()
                                    ->live()->default(1),

                                Radio::make('father_name')
                                    ->label('Father Name')
                                    ->boolean()
                                    ->inline()
                                    ->live()->default(1),

                                Radio::make('mother_name')
                                    ->label('Mother Name')
                                    ->boolean()
                                    ->inline()
                                    ->live()->default(1),

                                Radio::make('student_address')
                                    ->label('Address')
                                    ->boolean()
                                    ->inline()
                                    ->live()->default(1),

                                Radio::make('phone_number')
                                    ->label('Phone')
                                    ->boolean()
                                    ->inline()
                                    ->live()->default(1),

                                Radio::make('dob')
                                    ->label('Date of Birth')
                                    ->boolean()
                                    ->inline()
                                    ->live()->default(1),

                                Radio::make('blood')
                                    ->label('Blood Group')
                                    ->boolean()
                                    ->inline()
                                    ->live()->default(1),
                            ]),
                    ])
                    ->columnSpan(1),

                Section::make('ID Card Preview')
                    ->schema([

                        \Filament\Forms\Components\View::make('id-card.preview')
                            ->label(false)
                    ])->columnSpan(1)


            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            // Filament Table Columns
            ->columns([
                TextColumn::make('preview')
                    ->label('ID Card Preview')
                    ->getStateUsing(function ($record) {
                        return view('id-card.preview', [
                            'idcard' => $record,
                        ])->render();
                    }),
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
            'index' => Pages\ListIdcards::route('/'),
            'create' => Pages\CreateIdcard::route('/create'),
            'edit' => Pages\EditIdcard::route('/{record}/edit'),
        ];
    }
}
