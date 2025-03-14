<?php
namespace App\Admin\Resources\AddStudentResource\Widgets;

use App\Models\StudentAttendance;
use Filament\Widgets\ChartWidget;

class StudentAttendanceChart extends ChartWidget
{
    protected static ?string $heading = 'Attendance Overview';

  
    public ?int $studentId = null;

    protected function getData(): array
    {
        if (!$this->studentId) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $totalDays = StudentAttendance::where('student_id', $this->studentId)->count();
        $presentDays = StudentAttendance::where('student_id', $this->studentId)->where('status', 'Present')->count();
        $absentDays = $totalDays - $presentDays;

        return [
            'datasets' => [
                [
                    'label' => 'Attendance',
                    'data' => [$presentDays, $absentDays],
                    'backgroundColor' => ['#4CAF50', '#F44336'],
                ],
            ],
            'labels' => ['Present', 'Absent'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
