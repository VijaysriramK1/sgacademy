<?php

namespace App\Admin\Resources;

use App\Admin\Resources\AddStudentResource\Pages;
use App\Filament\Admin\Resources\AddStudentResource\RelationManagers;
use App\Models\AddStudent;
use App\Models\Smstudent;
use App\Models\Student;
use App\Models\Studentparents;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AddStudentResource extends Resource
{
    protected static ?string $model = Student::class;

    public static function getNavigationBadge(): ?string
    {
        return static::$model::count();
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Student Info';

    protected static ?string $navigationLabel = 'Student list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Add Student')
                    ->schema([
                        Wizard::make([

                            Wizard\Step::make('Personal Info')
                                ->icon('heroicon-o-user')
                                ->schema([
                                    TextInput::make('first_name')
                                        ->label('First Name')
                                        ->required(),
                                    TextInput::make('last_name')
                                        ->label('Last Name')->required(),
                                    TextInput::make('email')
                                        ->label('Email')
                                        ->email()
                                        ->unique(table: 'students', column: 'email', ignorable: fn($record) => $record),
                                    TextInput::make('mobile')
                                        ->label('Mobile')->required(),
                                    TextInput::make('admission_no')
                                        ->label('Admission No')->required()->numeric(),
                                    TextInput::make('roll_no')
                                        ->label('Roll No')->required()->numeric(),
                                    DatePicker::make('admission_date')
                                        ->label('Admission Date')->required(),
                                    DatePicker::make('dob')
                                        ->label('Date of Birth')->before('admission_date')->required(),
                                    Select::make('gender')
                                        ->label('Gender')
                                        ->options([
                                            'male' => 'Male',
                                            'female' => 'Female',
                                            'transgender' => 'Transgender',
                                            'non-binary' => 'Non-Binary',
                                            'other' => 'Other',
                                        ])->searchable()->native(false)->preload()->required(),
                                        Radio::make('status')
                                        ->options([
                                            '1' => 'Approved',
                                            '2' => 'Unapproved',
                                        ])->default('1')->required(),
                                    Select::make('blood_group')
                                        ->label('Blood Group')
                                        ->options([
                                            'A+' => 'A+',
                                            'A-' => 'A-',
                                            'B+' => 'B+',
                                            'B-' => 'B-',
                                            'AB+' => 'AB+',
                                            'AB-' => 'AB-',
                                            'O+' => 'O+',
                                            'O-' => 'O-',
                                            'other' => 'Other',
                                        ])->searchable()->native(false)->preload(),
                                    TextInput::make('height')
                                        ->label('Height'),
                                    TextInput::make('weight')
                                        ->label('Weight'),

                                    Textarea::make('current_address')
                                        ->label('Current Address'),
                                    Textarea::make('permanent_address')
                                        ->label('Permanent Address'),
                                    TextInput::make('national_id_no')
                                        ->label('National ID No'),
                                    TextInput::make('local_id_no')
                                        ->label('Local ID No'),
                                    FileUpload::make('student_photo')
                                        ->columnSpanFull()
                                        ->label('Photo')
                                        ->directory('student-photos')
                                        ->visibility('public')

                                ])->columns(2),


                            Wizard\Step::make('Parents & Guardian Info')
                                ->icon('heroicon-o-user-group')
                                ->schema([
                                    Select::make('relation')
                                        ->label('Relation')
                                        ->options([
                                            'parent' => 'Parent',
                                            'guardian' => 'Guardian',
                                            'grandparent' => 'Grandparent',
                                            'sibling' => 'Sibling',
                                            'spouse' => 'Spouse',
                                            'other' => 'Other',
                                        ])->searchable()->native(false)->preload(),
                                    Repeater::make('parents')

                                        ->schema([
                                            TextInput::make('first_name')
                                                ->label('Parent First Name')
                                                ->required(),
                                            TextInput::make('last_name')
                                                ->label('Parent Last Name'),
                                            TextInput::make('email')
                                                ->label('Parent Email')
                                                ->email()->required()->required(),
                                            TextInput::make('mobile')
                                                ->label('Parent Mobile')->required(),
                                            Select::make('gender')
                                                ->label('Parent Gender')
                                                ->options([
                                                    'male' => 'Male',
                                                    'female' => 'Female',
                                                    'transgender' => 'Transgender',
                                                    'non-binary' => 'Non-Binary',
                                                    'other' => 'Other',
                                                ])->searchable()->native(false)->preload(),
                                        ])->columns(2),
                                ]),

                            Wizard\Step::make('Document Info')
                                ->icon('heroicon-o-document')
                                ->schema([
                                    TextInput::make('document_title_1')
                                        ->label('Document Title 1'),
                                    FileUpload::make('document_file_1')
                                        ->label('Document File 1'),
                                    TextInput::make('document_title_2')
                                        ->label('Document Title 2'),
                                    FileUpload::make('document_file_2')
                                        ->label('Document File 2'),
                                    TextInput::make('document_title_3')
                                        ->label('Document Title 3'),
                                    FileUpload::make('document_file_3')
                                        ->label('Document File 3'),
                                    TextInput::make('document_title_4')
                                        ->label('Document Title 4'),
                                    FileUpload::make('document_file_4')
                                        ->label('Document File 4'),
                                ])->columns(2),

                            // Step 4: Previous School Information
                            Wizard\Step::make('Previous School Information')
                                ->icon('heroicon-o-academic-cap')
                                ->schema([
                                    textarea::make('custom_field')
                                        ->label('Additional Notes'),
                                    TextInput::make('custom_field_form_name')
                                        ->label('Custom Field Form Name'),
                                    TextInput::make('religion')
                                        ->label('Religion'),
                                ]),
                        ])->columnSpanFull(),
                    ]),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('admission_no')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('first_name')->sortable()->searchable()->label('Name')->formatStateUsing(fn ($record) => "{$record->first_name} {$record->last_name}")->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('mobile')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('email')->sortable()->searchable()->label('Email')->toggleable(isToggledHiddenByDefault: false),
                ImageColumn::make('student_photo')
                    ->label('Profile')
                    ->default(asset('logo/empty_profile.jpeg'))
                    ->url(fn($record) => filled($record->student_photo)
                        ? asset('storage/' . $record->student_photo)
                        : null)
                    ->circular()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    // Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ViewAction::make()
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
            'index' => Pages\ListAddStudents::route('/'),
            'create' => Pages\CreateAddStudent::route('/create'),
            'edit' => Pages\EditAddStudent::route('/{record}/edit'),
            'view' => Pages\ViewStudent::route('/{record}'),
        ];
    }
}
