<?php

namespace App\Admin\Resources\StudentSettingResource\Pages;

use App\Admin\Resources\StudentSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentSetting extends CreateRecord
{
    protected static string $resource = StudentSettingResource::class;
}
