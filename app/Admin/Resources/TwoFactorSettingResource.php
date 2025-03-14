<?php

namespace App\Admin\Resources;

use App\Admin\Clusters\GeneralSettings;
use App\Admin\Clusters\StudentSettings;
use App\Admin\Resources\TwoFactorSettingResource\Pages;
use App\Admin\Resources\TwoFactorSettingResource\RelationManagers;
use App\Models\TwoFactorSetting;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TwoFactorSettingResource extends Resource
{
    protected static ?string $model = TwoFactorSetting::class;

    protected static ?string $navigationIcon = '';

    protected static ?string $cluster = GeneralSettings::class;

    protected static ?string $navigationLabel = 'Two Factor Setting';
   
    protected static ?int $navigationSort = 2;

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
                ToggleColumn::make('via_sms')->searchable()->sortable()->label('Sms'),
                ToggleColumn::make('via_email')->searchable()->sortable()->label('Email'),
                ToggleColumn::make('for_admin')->searchable()->sortable()->label('Applicable for Admin'),
                ToggleColumn::make('for_student')->searchable()->sortable()->label('Student'),
                ToggleColumn::make('for_parent')->searchable()->sortable()->label('Parent'),
                ToggleColumn::make('for_teacher')->searchable()->sortable()->label('Teacher'),
                ToggleColumn::make('for_staff')->searchable()->sortable()->label('Staff'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('openExpiredTimeModal')
                    ->label('Time')
                    ->modalHeading('Set Expiration Time for Two Factor Authentication')
                    ->modalWidth('lg')
                    ->icon('heroicon-o-clock')
                    ->form([
                        TextInput::make('expired_time')
                            ->label('Expiration Time (in seconds)')
                            ->numeric()
                            ->required()
                            ->minValue(60)
                            ->maxValue(3600)
                            ->default(function () {
                                return TwoFactorSetting::find(1)?->expired_time ?? 300;
                            })
                            ->helperText('Set a value between 60 and 3600 seconds'),
                    ])
                    ->action(function (array $data) {
                        TwoFactorSetting::updateOrCreate(
                            ['id' => 1],
                            ['expired_time' => $data['expired_time']]
                        );
                        
                        Notification::make()
                            ->title('Expiration time updated successfully')
                            ->success()
                            ->send();
                    })
                    ->mutateFormDataUsing(function (array $data): array {
                        $currentTime = TwoFactorSetting::find(1)?->expired_time;
                        return [
                            'expired_time' => $currentTime ?? 300,
                        ];
                    }),

                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTwoFactorSettings::route('/'),
            'create' => Pages\CreateTwoFactorSetting::route('/create'),
            'edit' => Pages\EditTwoFactorSetting::route('/{record}/edit'),
        ];
    }
}
