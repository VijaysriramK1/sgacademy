<?php

namespace App\Admin\Resources\AssignStaffBatchProgramsResource\Pages;

use App\Admin\Resources\AssignStaffBatchProgramsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssignStaffBatchPrograms extends ListRecords
{
    protected static string $resource = AssignStaffBatchProgramsResource::class;

    public function getBreadcrumbs(): array
    {
      return [
        '#' => 'Assign Staff',
        '/admin/assign-staff-batch-programs' => 'List',
      ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Assign Staff'),
        ];
    }

    public function getHeading(): string
    {
        return 'Assigned Staff List';
    }
}
