<?php

namespace App\Admin\Resources;

use App\Admin\Clusters\GeneralSettings;
use App\Admin\Clusters\StudentSettings;
use App\Admin\Resources\StaffSettingResource\Pages;
use App\Admin\Resources\StaffSettingResource\RelationManagers;
use App\Models\StaffRegistrationField;
use App\Models\StaffSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StaffSettingResource extends Resource
{
    protected static ?string $model = StaffRegistrationField::class;

    protected static ?string $navigationIcon = '';

    protected static ?string $cluster = GeneralSettings::class;

    protected static ?string $navigationLabel = 'Staff Setting';
   
    protected static ?int $navigationSort = 3;


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
                ToggleColumn::make('staff_edit')->label('Staff Edit')->searchable()->sortable(),
                ToggleColumn::make('is_required')->label('Required')->searchable()->sortable()
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
            'index' => Pages\ListStaffSettings::route('/'),
            'create' => Pages\CreateStaffSetting::route('/create'),
            'edit' => Pages\EditStaffSetting::route('/{record}/edit'),
        ];
    }
}
