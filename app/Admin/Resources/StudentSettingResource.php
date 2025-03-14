<?php

namespace App\Admin\Resources;

use App\Admin\Clusters\GeneralSettings;
use App\Admin\Clusters\StudentSettings;
use App\Admin\Resources\StudentSettingResource\Pages;
use App\Admin\Resources\StudentSettingResource\RelationManagers;
use App\Models\Student;
use App\Models\StudentRegistrationField;
use App\Models\StudentSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentSettingResource extends Resource
{
    protected static ?string $model = StudentRegistrationField::class;

    protected static ?string $cluster = GeneralSettings::class;

    protected static ?string $navigationIcon = '';

    protected static ?string $navigationLabel = 'Student Setting';
   
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label_name')->label('Registration Field')->searchable()->sortable(),
                ToggleColumn::make('is_show')->label('Show')->sortable()->searchable()->disabled()->default(1),
                ToggleColumn::make('student_edit') ->label('Student Edit')->sortable()->searchable(),
                ToggleColumn::make('parent_edit') ->label('Parent Edit')->sortable()->searchable(),
                ToggleColumn::make('is_required') ->label('Required')->sortable()->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListStudentSettings::route('/'),
            'create' => Pages\CreateStudentSetting::route('/create'),
            'edit' => Pages\EditStudentSetting::route('/{record}/edit'),
        ];
    }
}
