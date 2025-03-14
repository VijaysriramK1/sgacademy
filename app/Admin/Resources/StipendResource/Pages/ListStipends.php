<?php

namespace App\Admin\Resources\StipendResource\Pages;

use App\Admin\Resources\StipendResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStipends extends ListRecords
{
    protected static string $resource = StipendResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getBreadcrumbs(): array
    {
       return [
        '/admin/stipends' => 'Add Stipend',
       ];
    }

    public function getTitle(): string
    {
       return 'Add Stipend';
    }
}
