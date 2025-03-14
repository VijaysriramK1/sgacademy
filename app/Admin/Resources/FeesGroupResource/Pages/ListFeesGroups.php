<?php

namespace App\Admin\Resources\FeesGroupResource\Pages;

use App\Admin\Resources\FeesGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeesGroups extends ListRecords
{
    protected static string $resource = FeesGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->Label('Add')->icon('heroicon-m-plus'),
        ];
    }
}
