<?php

namespace App\Admin\Resources\TwoFactorSettingResource\Pages;

use App\Admin\Resources\TwoFactorSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTwoFactorSetting extends CreateRecord
{
    protected static string $resource = TwoFactorSettingResource::class;
}
