<?php

namespace App\Admin\Resources\LeaveTypeResource\Pages;

use App\Admin\Resources\LeaveTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLeaveType extends EditRecord
{
    protected static string $resource = LeaveTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
