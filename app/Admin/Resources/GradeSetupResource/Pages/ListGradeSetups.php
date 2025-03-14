<?php

namespace App\Admin\Resources\GradeSetupResource\Pages;

use App\Admin\Resources\GradeSetupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGradeSetups extends ListRecords
{
    protected static string $resource = GradeSetupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add')->icon('heroicon-m-plus'),
        ];
    }
}
