<?php

namespace App\User\Resources\LeaveResource\Pages;

use App\User\Resources\LeaveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeaves extends ListRecords
{
    protected static string $resource = LeaveResource::class;

    public function getBreadcrumbs(): array
    {
      return [
        '#' => 'Leave',
        '/leaves' => 'List',
      ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getHeading(): string
    {
        return 'Leave';
    }
}
