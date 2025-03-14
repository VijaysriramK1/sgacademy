<?php

namespace App\Admin\Resources\TwoFactorSettingResource\Pages;

use App\Admin\Resources\TwoFactorSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTwoFactorSetting extends EditRecord
{
    protected static string $resource = TwoFactorSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
