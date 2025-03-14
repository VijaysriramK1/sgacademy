<?php

namespace App\Admin\Resources\AssignScholarshipResource\Pages;

use App\Admin\Resources\AssignScholarshipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssignScholarships extends ListRecords
{
    protected static string $resource = AssignScholarshipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Assign Scholarship'),
        ];
    }

    public function getBreadcrumbs(): array
    {
      return [
        '#' => 'Assign Scholarship',
        '/admin/assign-scholarships' => 'List',
      ];
    }

    public function getHeading(): string
    {
        return 'Assign Scholarship List';
    }
}
