<?php

namespace App\Admin\Resources\LeaveTypeResource\Pages;

use App\Admin\Resources\LeaveTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeaveType extends ListRecords
{
    protected static string $resource = LeaveTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create Leave Type'),
        ];
    }
}
