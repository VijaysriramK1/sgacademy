<?php

namespace App\Admin\Resources\StaffSettingResource\Pages;

use App\Admin\Resources\StaffSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStaffSetting extends CreateRecord
{
    protected static string $resource = StaffSettingResource::class;
}
