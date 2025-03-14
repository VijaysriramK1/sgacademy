<?php

namespace App\Admin\Resources\StudentgroupResource\Pages;

use App\Admin\Resources\StudentgroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentgroups extends ListRecords
{
    protected static string $resource = StudentgroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add')->icon('heroicon-m-plus'),
        ];
    }
}
