<?php

namespace App\Admin\Resources\CourseSectionResource\Pages;

use App\Admin\Resources\CourseSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCourseSections extends ListRecords
{
    protected static string $resource = CourseSectionResource::class;

    protected function getCreateAnotherFormAction(): Action
    {
    return parent::getCreateAnotherFormAction()->visible(false);
    }

    public function getBreadcrumbs(): array
    {
      return [
        '#' => 'Assign Course',
        '/admin/course-sections' => 'List',
      ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Assign Course')->icon('heroicon-m-plus'),
        ];
    }

    public function getHeading(): string
    {
        return 'Assigned Courses';
    }
}
