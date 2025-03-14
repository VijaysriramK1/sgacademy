<?php

namespace App\Admin\Resources\BatchProgramResource\Pages;

use App\Admin\Resources\BatchProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBatchPrograms extends ListRecords
{
    protected static string $resource = BatchProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add')->icon('heroicon-m-plus'),
        ];
    }
}
