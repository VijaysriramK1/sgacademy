<?php

namespace App\Admin\Resources\LeaveResource\Pages;

use App\Admin\Resources\LeaveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeave extends ListRecords
{
    protected static string $resource = LeaveResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
