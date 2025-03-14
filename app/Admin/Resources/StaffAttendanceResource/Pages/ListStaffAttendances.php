<?php

namespace App\Admin\Resources\StaffAttendanceResource\Pages;

use App\Admin\Resources\StaffAttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStaffAttendances extends ListRecords
{
    protected static string $resource = StaffAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getBreadcrumbs(): array
    {
      return [
        '/admin/staff-attendances' => 'Staff Attendance',
      ];
    }

    public function getTitle(): string
    {
        return 'Staff Attendance';
    }
}
