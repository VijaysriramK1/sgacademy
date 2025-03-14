<?php

namespace App\User\Resources\DashboardResource\Widgets;

use App\Models\Student;
use App\Models\Studentparents;
use App\Helpers\UserHelper;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Session;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ParentStatsOverview extends BaseWidget
{
    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        $get_student_details = Studentparents::where('parent_id', UserHelper::currentRoleDetails()->id)->count();

        $student_description = $get_student_details > 0 ? 'Total students assigned to you.' : 'No students are currently assigned to you.';
        $student_icon = $get_student_details > 0 ? 'heroicon-m-user-group' : 'heroicon-m-user-group';
        $student_color = $get_student_details > 0 ? 'primary' : 'info';

        return [
            Stat::make(label: 'Total Students', value: $get_student_details)
            ->description(description: $student_description)
            ->descriptionIcon(icon: $student_icon)
            ->color(color: $student_color),
        ];

    }

}
