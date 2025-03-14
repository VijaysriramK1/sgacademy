<?php

namespace App\User\Resources\MyStudentsResource\Pages;

use App\User\Resources\MyStudentsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMyStudents extends ListRecords
{
    protected static string $resource = MyStudentsResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getBreadcrumbs(): array
    {
      return [
        '/my-students' => 'My Students',
      ];
    }

    public function getTitle(): string
    {
       return 'My Students';
    }

}
