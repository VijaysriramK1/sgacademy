<?php

namespace App\User\Resources;

use App\User\Resources\CoursesResource\Pages;
use App\User\Resources\CoursesResource\RelationManagers;
use App\Helpers\UserHelper;
use App\Models\Courses;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoursesResource extends Resource
{
    protected static ?string $model = Courses::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Courses';

    protected static ?int $navigationSort = 2;

    public static ?string $label = 'Courses';

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
        if ($role == 'student' || $role == 'parent') {
            $get_permissions = UserHelper::currentRolePermissionDetails();
            if (in_array('courses', $get_permissions)) {
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'detail' => Pages\DetailCourses::route('/{record}/details'),
        ];
    }
}
