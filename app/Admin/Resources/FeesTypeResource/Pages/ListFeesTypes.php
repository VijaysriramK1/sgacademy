<?php

namespace App\Admin\Resources\FeesTypeResource\Pages;

use App\Admin\Resources\FeesTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeesTypes extends ListRecords
{
    protected static string $resource = FeesTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->Label('Add')->icon('heroicon-m-plus'),
        ];
    }
}
