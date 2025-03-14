<?php

namespace App\Admin\Resources;

use App\Admin\Resources\RoleResource\Pages;
use App\Admin\Resources\RoleResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Table;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Role & Permission';

    protected static ?string $navigationLabel = 'Roles';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Role Details')
                ->schema([
                TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->disabled(fn (Model $record) => $record && $record->exists),

                CheckboxList::make('permissions')
                ->label('Permissions')
                ->relationship('permissions', 'name')
                ->options(function ($record) {
                    if ($record->id == 2) {
                       $guard = 'student';
                    } else if ($record->id == 3) {
                        $guard = 'parent';
                    } else if ($record->id == 4) {
                        $guard = 'staff';
                    } else {
                        $guard = 'web';
                    }
                    return Permission::where('guard_name', $guard)->pluck('name', 'id');
                })
                ])->columns(2)
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')->label('S.No')
                ->rowIndex(),

                TextColumn::make('name')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Assign Permission')->icon('heroicon-o-shield-check'),
            ])
            ->bulkActions([]);
    }

    public static function canCreate(): bool
{
    return auth()->user()->can('manage roles');
}

public static function canView(Model $record): bool
{
    return auth()->user()->can('view roles');
}


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->whereNotIn('name', ['admin']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
