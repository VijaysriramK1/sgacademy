<?php

namespace App\Admin\Resources;

use App\Admin\Resources\CourseSectionResource\Pages;
use App\Admin\Resources\CourseSectionResource\RelationManagers;
use App\Models\Semester;
use App\Models\BatchPrograms;
use App\Models\courseSection;
use App\Models\CourseSections;
use Filament\Forms;
use App\Models\Courses;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\MultiSelect;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseSectionResource extends Resource
{
    protected static ?string $model = courseSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 11;

    protected static ?string $navigationGroup = 'Batches';

    protected static ?string $navigationLabel = 'Assign Course';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Assign Course')
                    ->schema([
                        Select::make('batch_program_id')
                        ->options(function () {
                           return BatchPrograms::where('status', 1)->pluck('batch_group', 'id');
                        })
                        ->label('Batch Program')
                        ->required(),

                        Select::make('semester_id')
                        ->options(function () {
                           return Semester::all()->pluck('name', 'id');
                        })
                        ->label('Semester')
                        ->required(),

                        MultiSelect::make('courses')
                        ->options(function () {
                            return Courses::where('status', 1)->pluck('name', 'id');
                        })
                        ->label('Courses')
                        ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sl')->rowIndex(),
                TextColumn::make('batch_program_id')
                ->label('Batch Program')
                ->getStateUsing(function ($record) {
                  $batch_program = BatchPrograms::where('id', $record->batch_program_id)->value('batch_group');
                    return $batch_program ?? '--';
                }),
                TextColumn::make('semester_id')
                ->label('Semester')
                ->getStateUsing(function ($record) {
                  $semester = Semester::where('id', $record->semester_id)->value('name');
                    return $semester ?? '--';
                }),
                TextColumn::make('courses')
                  ->label('Courses')
                  ->getStateUsing(function ($record) {
                      $check_record = Courses::whereIn('id', $record->courses)->get();

                      $badges = $check_record->map(function ($course) {
                        return'<span style="margin-left: 5px;background-color: #3B82F6;color: white;padding: 4px 8px;text-align: center;border-radius: 5px;">' . $course->name . '</span>';
                    });

                    $chunkedBadges = $badges->chunk(3);

                    return $chunkedBadges->map(function ($chunk) {
                        return '<div style="margin-top: 5px;display: flex; flex-wrap: wrap;">' . $chunk->implode('') . '</div>';
                    })->implode('');

                    })->html(),
            ])
            ->filters([
                //
            ])
            ->emptyState(fn() => new HtmlString('<div style="text-align: center; font-size: 18px; font-weight: bold; color: #888; margin-top: 25px; margin-bottom: 25px;">No records found.</div>'))
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListCourseSections::route('/'),
            'create' => Pages\CreateCourseSection::route('/create'),
            'edit' => Pages\EditCourseSection::route('/{record}/edit'),
        ];
    }
}
