<?php

namespace App\Admin\Resources\StaffSettingResource\Pages;

use App\Admin\Resources\StaffSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStaffSettings extends ListRecords
{
    protected static string $resource = StaffSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
