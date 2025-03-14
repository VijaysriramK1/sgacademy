<?php

namespace App\Admin\Resources\UserSettingResource\Pages;

use App\Admin\Resources\UserSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserSetting extends EditRecord
{
    protected static string $resource = UserSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
