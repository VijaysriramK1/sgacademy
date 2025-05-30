<?php

namespace App\Admin\Resources\StudentSettingResource\Pages;

use App\Admin\Resources\StudentSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentSetting extends EditRecord
{
    protected static string $resource = StudentSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
