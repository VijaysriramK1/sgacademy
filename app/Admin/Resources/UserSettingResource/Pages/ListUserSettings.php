<?php

namespace App\Admin\Resources\UserSettingResource\Pages;

use App\Admin\Resources\UserSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserSettings extends ListRecords
{
    protected static string $resource = UserSettingResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}
