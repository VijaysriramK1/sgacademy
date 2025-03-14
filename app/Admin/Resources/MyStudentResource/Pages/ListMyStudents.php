<?php

namespace App\Admin\Resources\MyStudentResource\Pages;

use App\Admin\Resources\MyStudentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMyStudents extends ListRecords
{
    protected static string $resource = MyStudentResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getBreadcrumbs(): array
    {
      return [
        '/admin/my-students' => 'My Students',
      ];
    }

    public function getTitle(): string
    {
        return 'My Students';
    }
}
