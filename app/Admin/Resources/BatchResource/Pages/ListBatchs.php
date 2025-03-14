<?php

namespace App\Admin\Resources\BatchResource\Pages;

use App\Admin\Resources\BatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBatchs extends ListRecords
{
    protected static string $resource = BatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add')->icon('heroicon-m-plus'),
        ];
    }
}
