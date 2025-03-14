<?php

namespace App\Admin\Resources;

use App\Admin\Clusters\GeneralSettings;
use App\Admin\Resources\UserSettingResource\Pages;
use App\Admin\Resources\UserSettingResource\RelationManagers;
use App\Models\User;
use App\Models\UserSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserSettingResource extends Resource
{
    protected static ?string $model = User::class;



    protected static ?string $cluster = GeneralSettings::class;

    protected static ?string $navigationIcon = '';

    protected static ?string $navigationLabel = 'User Setting';
   
    protected static ?int $navigationSort = 4;

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
                Tables\Columns\TextColumn::make('id')->label('ID')->rowIndex()->sortable()->wrap()->listWithLineBreaks(),
                Tables\Columns\TextColumn::make('first_name')->label('First Name')->searchable()->sortable()->wrap()->listWithLineBreaks(),
                Tables\Columns\TextColumn::make('last_name')->label('Last Name')->searchable()->sortable()->wrap()->listWithLineBreaks(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable()->sortable()->wrap()->listWithLineBreaks(),
                Tables\Columns\TextColumn::make('username')->label('Username')->searchable()->sortable()->wrap()->listWithLineBreaks(),
                Tables\Columns\TextColumn::make('mobile')->label('Mobile')->searchable()->sortable()->wrap()->listWithLineBreaks(),
                Tables\Columns\TextColumn::make('user_type')->label('User Type')->searchable()->sortable()->wrap()->listWithLineBreaks(),
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
            'index' => Pages\ListUserSettings::route('/'),
            'create' => Pages\CreateUserSetting::route('/create'),
            'edit' => Pages\EditUserSetting::route('/{record}/edit'),
        ];
    }
}
