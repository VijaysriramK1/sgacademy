<?php

namespace App\Admin\Resources;

use App\Admin\Resources\HomeworkResource\Pages;
use App\Admin\Resources\HomeworkResource\RelationManagers;
use App\Models\Homework;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section as ComponentsSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Date;

use function Laravel\Prompts\select;

class HomeworkResource extends Resource
{
    protected static ?string $model = Homework::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Student Info';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ComponentsSection::make('Add Homework')
                ->schema([
                       DatePicker::make('homework_date')
                       ->label('Homework Date'),
                       DatePicker::make('submission_date')
                       ->label('Submission Date') ,
                       DatePicker::make('evaluation_date')
                       ->label('Evaluation Date'),
                       TextInput::make('marks')
                       ->label('Marks'),
                     
                       Select::make('evaluated_by')
                       ->relationship('evaluatedBy', 'roll_no')->searchable()->native(false)->preload(),
                       Select::make('program_id')
                       ->relationship('program', 'name')->searchable()->native(false)->preload(),
                       Select::make('section_id')
                       ->relationship('section', 'name')->searchable()->native(false)->preload(),
                       select::make('course_id')
                       ->relationship('course', 'name')->searchable()->native(false)->preload(),
                    Textarea::make('description')
                    ->label('Description')->columnSpanFull(),
                    FileUpload::make('file')
                    ->label('File')->columnSpanFull(),

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
                TextColumn::make('id')->sortable()->rowIndex(),
                TextColumn::make('homework_date')->date('d-m-Y')->searchable()->sortable(),
                TextColumn::make('submission_date')->date('d-m-Y')->searchable()->sortable(),
                TextColumn::make('evaluation_date')->date('d-m-Y')->searchable()->sortable(),
                TextColumn::make('marks')->searchable()->sortable(),
                TextColumn::make('evaluatedBy.roll_no')->searchable()->sortable(),
                TextColumn::make('program.name')->searchable()->sortable(),
                TextColumn::make('section.name')->searchable()->sortable(),
                TextColumn::make('course.name')->searchable()->sortable(),
                TextColumn::make('description')->searchable()->sortable(),
               
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
                ->searchable()->sortable(),
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
            'index' => Pages\ListHomework::route('/'),
            'create' => Pages\CreateHomework::route('/create'),
            'edit' => Pages\EditHomework::route('/{record}/edit'),
        ];
    }
}
