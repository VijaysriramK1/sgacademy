<?php

namespace App\Admin\Resources\StaffAttendanceReportResource\Pages;

use App\Admin\Resources\StaffAttendanceReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStaffAttendanceReports extends ListRecords
{
    protected static string $resource = StaffAttendanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getBreadcrumbs(): array
    {
      return [
        '/admin/staff-attendance-reports' => 'Staff Attendance Report',
      ];
    }

    public function getTitle(): string
    {
        return 'Staff Attendance Report';
    }

}
