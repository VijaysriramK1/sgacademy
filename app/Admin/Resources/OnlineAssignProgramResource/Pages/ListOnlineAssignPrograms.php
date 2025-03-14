<?php

namespace App\Admin\Resources\OnlineAssignProgramResource\Pages;

use App\Admin\Resources\OnlineAssignProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOnlineAssignPrograms extends ListRecords
{
    protected static string $resource = OnlineAssignProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Assign Program')->icon('heroicon-m-plus'),
        ];
    }
}
