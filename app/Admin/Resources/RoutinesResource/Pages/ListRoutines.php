<?php

namespace App\Admin\Resources\RoutinesResource\Pages;

use App\Admin\Resources\RoutinesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoutines extends ListRecords
{
    protected static string $resource = RoutinesResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }


    public function getBreadcrumbs(): array
    {
      return [
        '/admin/routines' => 'Routines',
      ];
    }

    public function getTitle(): string
    {
      return 'Routines';
    }
}
