<?php

namespace App\User\Resources;

use App\User\Resources\MyProgramsResource\Pages;
use App\User\Resources\MyProgramsResource\RelationManagers;
use App\Models\Courses;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Helpers\UserHelper;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MyProgramsResource extends Resource
{
    protected static ?string $model = Courses::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?string $navigationGroup = 'Program';

    protected static ?string $navigationLabel = 'My Program';

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
                //
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function canAccess(): bool
    {
        $role = UserHelper::currentRole();
        if ($role == 'staff') {
            $get_permissions = UserHelper::currentRolePermissionDetails();
            if (in_array('my-programs', $get_permissions)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    protected static function getNavigationPages(): array
    {
        return [
            Pages\ViewMyPrograms::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\MyPrograms::route('/'),
            'detail' => Pages\ViewMyPrograms::route('/{record}/details'),
        ];
    }


}
