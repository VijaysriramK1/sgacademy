<?php

namespace App\User\Resources\AttendanceReportResource\Pages;

use App\User\Resources\AttendanceReportResource;
use Filament\Actions;
use App\Helpers\UserHelper;
use Filament\Resources\Pages\ListRecords;

class ListAttendanceReports extends ListRecords
{
    protected static string $resource = AttendanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getBreadcrumbs(): array
    {
        $role = UserHelper::currentRole();

        if ($role == 'student') {
            return [
                '#' => 'Attendance Report',
                '/attendance-reports' => 'List',
              ];
        } else {
            return [
                '#' => 'Student Attendance Report',
                '/attendance-reports' => 'List',
              ];
        }
    }

    public function getHeading(): string
    {
        $role = UserHelper::currentRole();

        if ($role == 'student') {
            return 'Attendance Report';
        } else {
            return 'Student Attendance Report';
        }

    }
}
