<?php

namespace App\Admin\Resources;

use App\Admin\Resources\CertificateResource\Pages;
use App\Admin\Resources\CertificateResource\RelationManagers;
use App\Models\Certificate;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Student Info';

    protected static ?string $navigationLabel = 'Certificate';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Add Certificate')
                    ->schema([
                        TextInput::make('header_text')->label('Header Left Text'),
                        Section::make('Header Style')->schema([
                            TextInput::make('header_left_text')
                                ->label('Header Left Text')->live()->numeric(),
                            TextInput::make('header_buttom_text')
                                ->label('Header Buttom Text')->live()->numeric(),
                            TextInput::make('header_right_text')
                                ->label('Header Right Text')->live()->numeric(),
                            TextInput::make('header_top_text')
                                ->label('Header Top Text')->live()->numeric(),
                            TextInput::make('header_font_size')->label('Font Size')->live()->numeric(),
                            ColorPicker::make('header_text_color')->label('Header Text Color')->live()
                        ])->columns(2),

                        TextInput::make('title')->label('Title'),
                        Section::make('Title Style')->schema([
                            TextInput::make('title_left_text')
                                ->label('Title Left Text')->live()->numeric(),
                            TextInput::make('title_bottom_text')
                                ->label('Title Bottom Text')->live()->numeric(),
                            TextInput::make('title_right_text')
                                ->label('Title Right Text')->live()->numeric(),
                            TextInput::make('title_top_text')
                                ->label('Title Top Text')->live()->numeric(),
                            TextInput::make('title_font_size')->label('Font Size')->live()->numeric(),
                            ColorPicker::make('title_text_color')->label('Title Text Color')->live(),
                        ])->columns(2),


                        DatePicker::make('date')->label('Date'),
                        Section::make('Date Style')->schema([
                            TextInput::make('date_left_text')
                                ->label('Date Left Text')->live()->numeric(),
                            TextInput::make('date_buttom_text')
                                ->label('Date Buttom Text')->live()->numeric(),
                            TextInput::make('date_right_text')
                                ->label('Date Right Text')->live()->numeric(),
                            TextInput::make('date_top_text')
                                ->label('Date Top Text')->live()->numeric(),
                            TextInput::make('date_font_size')->label('Font Size')->live()->numeric(),
                            ColorPicker::make('date_text_color')->label('Date Text Color')->live()
                        ])->columns(2),
                        Textarea::make('body')->label('Body')->columnSpanFull(),
                        section::make('Body Style')->schema([
                        TextInput::make('footer_left_text')->label('Footer Left Text')->numeric(),
                        TextInput::make('footer_center_text')->label('Footer Center Text')->numeric(),
                        TextInput::make('footer_right_text')->label('Footer Right Text')->numeric(),
                        TextInput::make('footer_top_text')->label('Footer Top Text')->numeric(),
                        TextInput::make('footer_font_size')->label('Font Size')->live()->numeric(),
                        ColorPicker::make('footer_text_color')->label('Footer Text Color')->live()
                        ])->columns(2),
                          FileUpload::make('data.file')
                        ->label('Background Image')
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory('certificates')
                        ->visibility('public')
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if (is_string($state)) {
                                $set('data.file', $state);
                            } else {
                                $set('data.file', null);
                            }
                        })
                        ->columnSpanFull(),

                        TextInput::make('height')
                            ->label('Height (mm)'),
                        TextInput::make('width')
                            ->label('Width (mm)')->helperText('Enter a value between 50 and 550')
                            ->minValue(50)
                            ->maxValue(550)
                            ->live()
                            ->default(550)
                            ->afterStateUpdated(function ($set, $state) {
                                if ($state > 550) {
                                    $set('Width', 550);
                                    return;
                                }
                                $columnSpan = $state > 550 ? 2 : 1;
                                $set('preview_column_span', $columnSpan);
                            }),
                        Radio::make('student_photo')->boolean()->default(1)->live()
                    ])->columnSpan(1),
                    section::make()->schema([
                        \Filament\Forms\Components\View::make('certificate')
                        ->label(false)
                    ])->columnSpan(1)
            ])->columns(2);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable()->width(150),
                ImageColumn::make('file')
                    ->label('Layout')->width(200)->height(200)

                    ->getStateUsing(fn($record) => $record->file)
                    ->url(fn($record) => $record->file
                        ? asset('storage/' . $record->file)
                        : asset(''))->searchable()->sortable(),
                TextColumn::make('body')->label('Body')->wrap()->searchable()->sortable()->listWithLineBreaks()->width(200)
            ],3)
            ->filters([
                //
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
            'index' => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit' => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }

}
