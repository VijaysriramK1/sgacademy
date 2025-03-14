<?php

namespace App\Admin\Resources\ClassRoutineResource\Pages;

use App\Admin\Resources\ClassRoutineResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassRoutines extends ListRecords
{
    protected static string $resource = ClassRoutineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create Routine'),
        ];
    }

    public function getBreadcrumbs(): array
    {
       return [
        '#' => 'Class Routine',
        '/admin/class-routines' => 'List',
       ];
    }

    public function getTitle(): string
    {
       return 'Class Routine List';
    }

}
