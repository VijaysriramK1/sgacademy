<?php

namespace App\Admin\Resources;

use App\Admin\Resources\StudyMaterialResource\Pages;
use App\Models\BatchPrograms;
use App\Models\Program;
use App\Models\Section as ModelsSection;
use App\Models\StudyMaterial;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudyMaterialResource extends Resource
{
    protected static ?string $model = StudyMaterial::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Student Info';

    protected static ?string $navigationLabel = 'Study Material';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Content Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('content_title')
                            ->label('Title')
                            ->required(),

                        Select::make('content_type')
                            ->label('Content Type')
                            ->required()
                            ->options([
                                'as' => 'Assignment',
                                'sy' => 'syllabus',
                                'ot' => 'Other download',
                            ])->searchable()->preload()->native(false),

                        Forms\Components\Group::make()
                            ->schema([
                                Toggle::make('available_for_admin')
                                    ->label('Available for Admins'),

                                Toggle::make('available_for_student')
                                    ->label('Available for Students')
                                    ->live(),
                            ])
                            ->columns(2),

                        Forms\Components\Toggle::make('all_classes')
                            ->label('Available for All Classes')
                            ->live(),
                    ]),

                Section::make('Student Access')
                    ->schema([

                        Forms\Components\Grid::make(2)
                            ->schema([

                                $table = Select::make('program_id')
                                    ->label('Class')
                                    ->options(
                                        Program::query()
                                            ->pluck('name', 'id')
                                            ->toArray()
                                    )
                                    ->visible(
                                        fn($get) =>
                                        $get('available_for_student') &&
                                            !$get('all_classes')
                                    )

                                    ->required()
                                    ->preload()
                                    ->native(false)
                                    ->searchable()
                                    ->columnSpanFull(),

                                Select::make('section_id')
                                    ->label('Section')
                                    ->options(function () use ($table) {
                                        $state = $table->getState();

                                        $sections = BatchPrograms::query()
                                            ->where('program_id', $state)
                                            ->pluck('section_id');
                                        $section = ModelsSection::query()
                                            ->whereIn('id', $sections)
                                            ->pluck('name', 'id');
                                        return $section->toArray();
                                    })
                                    ->visible(
                                        fn($get) =>
                                        $get('available_for_student') &&
                                            !$get('all_classes')
                                    )
                                    ->required()
                                    ->preload()
                                    ->native(false)
                                    ->searchable()
                                    ->columnSpanFull(),
                            ])


                    ]),

                Section::make('Additional Information')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('upload_date')
                            ->label('Upload Date')
                            ->default(now()),

                        TextInput::make('source_url')
                            ->label('Source Url')
                            ->url(),

                        Textarea::make('description')
                            ->label('Description')
                            ->columnSpanFull(),

                        FileUpload::make('upload_file')
                            ->label('file')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('id')
                    ->label('SL')
                    ->rowIndex()
                    ->sortable(),


                TextColumn::make('content_title')
                    ->label('Content Title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('content_type')
                    ->label('Type')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'as' => 'Assignment',
                        'sy' => 'Syllabus',
                        'ot' => 'Other Download',
                        default => $state
                    })
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'as' => 'success',
                        'sy' => 'danger',
                        'ot' => 'info'
                    })
                    ->searchable()
                    ->sortable(),


                TextColumn::make('upload_date')
                    ->label('Date')
                    ->date('d M, Y')
                    ->sortable(),

                TextColumn::make('available_for')
                    ->label('Available for')
                    ->getStateUsing(function (StudyMaterial $record) {

                        if ($record->available_for_admin == 1 && $record->available_for_all_programs == 0) {
                            $details = 'All Admins';
                        } elseif ($record->available_for_admin == 0 && $record->available_for_all_programs == 0) {

                            $program = $record->program;
                            $section = $record->section;
                            if ($program && $section) {
                                return 'All Students of ' . $program->name . ' -> ' . $section->name;
                            }

                            return '';
                        } else {
                            $details = 'All Admins';
                        }

                        return $details;
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('program_id')
                    ->label('Program(Section)')
                    ->getStateUsing(function (StudyMaterial $record) {
                        $program = $record->program;
                        $section = $record->section;
                        if ($program && $section) {
                            return  $program->name . ' ( ' . $section->name . ')';
                        }
                    })


            ])
            ->filters([
                Tables\Filters\SelectFilter::make('content_type')
                    ->options([
                        'as' => 'Assignment',
                        'sy' => 'Syllabus',
                        'ot' => 'Others Download',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListStudyMaterials::route('/'),
            'create' => Pages\CreateStudyMaterial::route('/create'),
            'edit' => Pages\EditStudyMaterial::route('/{record}/edit'),
        ];
    }
}
