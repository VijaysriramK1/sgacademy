<?php

namespace App\User\Resources\DashboardResource\Widgets;

use App\Models\Courses;
use App\Models\courseSection;
use App\Models\Enrollment;
use App\Helpers\UserHelper;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Session;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StudentStatsOverview extends BaseWidget
{
    protected static bool $isLazy = true;

    protected function getStats(): array
    {

       $get_course_details = Courses::whereIn('id', courseSection::where('batch_program_id', Enrollment::where('student_id', UserHelper::currentRoleDetails()->id)->value('batch_program_id'))->first()->courses)->count();

        $course_description = $get_course_details > 0 ? 'Total courses assigned to your batch program.' : 'No courses assigned to your batch program.';
        $course_icon = $get_course_details > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $course_color = $get_course_details > 0 ? 'primary' : 'info';

        return [
            Stat::make(label: 'Total Courses', value: $get_course_details)
            ->description(description: $course_description)
            ->descriptionIcon(icon: $course_icon)
            ->color(color: $course_color),
        ];

    }

}
