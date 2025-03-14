<?php

namespace App\Admin\Resources\TwoFactorSettingResource\Pages;

use App\Admin\Resources\TwoFactorSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTwoFactorSettings extends ListRecords
{
    protected static string $resource = TwoFactorSettingResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }

    protected static ?string $title = 'Two Factor Settings';
}
