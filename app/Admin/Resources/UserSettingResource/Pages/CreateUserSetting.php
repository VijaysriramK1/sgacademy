<?php

namespace App\Admin\Resources\UserSettingResource\Pages;

use App\Admin\Resources\UserSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserSetting extends CreateRecord
{
    protected static string $resource = UserSettingResource::class;
}
