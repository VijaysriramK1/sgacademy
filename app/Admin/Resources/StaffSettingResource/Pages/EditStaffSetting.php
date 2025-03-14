<?php

namespace App\Admin\Resources\StaffSettingResource\Pages;

use App\Admin\Resources\StaffSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStaffSetting extends EditRecord
{
    protected static string $resource = StaffSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
