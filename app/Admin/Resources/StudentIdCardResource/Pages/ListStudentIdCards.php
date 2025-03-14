<?php

namespace App\Admin\Resources\StudentIdCardResource\Pages;

use App\Admin\Resources\StudentIdCardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentIdCards extends ListRecords
{
    protected static string $resource = StudentIdCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-m-plus')->label('Create Id Card'),
        ];
    }
}
