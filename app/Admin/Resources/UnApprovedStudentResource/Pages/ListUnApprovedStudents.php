<?php

namespace App\Admin\Resources\UnApprovedStudentResource\Pages;

use App\Admin\Resources\UnApprovedStudentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnApprovedStudents extends ListRecords
{
    protected static string $resource = UnApprovedStudentResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getBreadcrumbs(): array
    {
      return [
        '/admin/un-approved-students' => 'Un Approved Students',
      ];
    }

    public function getTitle(): string
    {
        return 'Un Approved Students';
    }
}
