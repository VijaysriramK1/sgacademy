<?php

namespace App\User\Resources\AttendanceResource\Pages;

use App\User\Resources\AttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttendances extends ListRecords
{
    protected static string $resource = AttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getBreadcrumbs(): array
    {
      return [
        '#' => 'Student Attendance',
        '/attendances' => 'List',
      ];
    }

    public function getHeading(): string
    {
        return 'Student Attendance';
    }
}
