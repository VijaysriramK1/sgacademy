<?php

namespace App\User\Resources\DashboardResource\Widgets;

use App\Models\Courses;
use App\Models\Enrollment;
use App\Models\Semester;
use App\Helpers\UserHelper;
use App\Models\BatchPrograms;
use App\Models\AssignStaffBatchProgram;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Session;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StaffStatsOverview extends BaseWidget
{
    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        if (Session::has('staff_dashboard_selected_batch_program') && !empty(Session::get('staff_dashboard_selected_batch_program'))) {
            $batch_program_id = Session::get('staff_dashboard_selected_batch_program');
            $get_student_details = Enrollment::where('batch_program_id', $batch_program_id)->count();
            $get_semester_details = Semester::whereIn('id', AssignStaffBatchProgram::where('staff_id', UserHelper::currentRoleDetails()->id)->where('batch_program_id', $batch_program_id)->pluck('semester_id'))->count();
            $get_course_details = Courses::whereIn('id', AssignStaffBatchProgram::where('staff_id', UserHelper::currentRoleDetails()->id)->where('batch_program_id', $batch_program_id)->first()->course_id)->count();
        } else {
            $get_student_details = 0;
            $get_semester_details = 0;
            $get_course_details = 0;
        }

        $student_description = $get_student_details > 0 ? 'Total students enrolled in the selected batch program.' : 'No students enrolled in the selected batch program.';
        $student_icon = $get_student_details > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $student_color = $get_student_details > 0 ? 'primary' : 'info';

        $semester_description = $get_semester_details > 0 ? 'Total semesters assigned to the selected batch program.' : 'No semesters assigned to the selected batch program.';
        $semester_icon = $get_semester_details > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $semester_color = $get_semester_details > 0 ? 'primary' : 'info';

        $course_description = $get_course_details > 0 ? 'Total courses assigned to the selected batch program.' : 'No courses assigned to the selected batch program.';
        $course_icon = $get_course_details > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $course_color = $get_course_details > 0 ? 'primary' : 'info';

        return [
            Stat::make(label: 'Total Students', value: $get_student_details)
            ->description(description: $student_description)
            ->descriptionIcon(icon: $student_icon)
            ->color(color: $student_color),

            Stat::make(label: 'Total Semesters', value: $get_semester_details)
            ->description(description: $semester_description)
            ->descriptionIcon(icon: $semester_icon)
            ->color(color: $semester_color),

            Stat::make(label: 'Total Courses', value: $get_course_details)
            ->description(description: $course_description)
            ->descriptionIcon(icon: $course_icon)
            ->color(color: $course_color),
        ];

    }

}
