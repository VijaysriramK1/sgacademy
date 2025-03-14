<?php

namespace App\User\Resources\RoutinesResource\Pages;

use App\User\Resources\RoutinesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoutines extends ListRecords
{
    protected static string $resource = RoutinesResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
