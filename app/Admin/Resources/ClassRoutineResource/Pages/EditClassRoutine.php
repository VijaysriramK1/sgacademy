<?php

namespace App\Admin\Resources\ClassRoutineResource\Pages;

use App\Admin\Resources\ClassRoutineResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClassRoutine extends EditRecord
{
    protected static string $resource = ClassRoutineResource::class;

    public function getBreadcrumbs(): array
    {
       $record_id = request()->route('record');
       return [
        '#' => 'Class Routine',
        '/admin/class-routines/' . $record_id . '/edit' => 'Edit',
       ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getHeading(): string
    {
        return 'Class Routine Edit';
    }

}
