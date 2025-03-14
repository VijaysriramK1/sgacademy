<?php

namespace App\User\Resources\DashboardResource\Widgets;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use App\Models\Routine;
use App\Helpers\UserHelper;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Session;
use App\Models\AssignStaffBatchProgram;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class StaffCalendar extends FullCalendarWidget
{
    public Model | string | null $model = Routine::class;

    protected function headerActions(): array
    {
        return [];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Routine::with('course', 'lesson')
            ->where('start_date', '>=', $fetchInfo['start'])
            ->where('end_date', '<=', $fetchInfo['end'])
            ->where('staff_id', UserHelper::currentRoleDetails()->id)
            ->where('batch_program_id', Session::get('staff_dashboard_selected_batch_program'))
            ->get()
            ->map(function (Routine $routine) {
                return [
                    'id'    => $routine->id,
                    'title' => "Course: {$routine->course->name}\nLesson: {$routine->lesson->title}",
                    'start' => $routine->start_date,
                    'end'   => $routine->end_date,
                ];
            })
            ->toArray();
    }


    public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,dayGridWeek',
            ],
            'eventContent' => 'function(arg) { return { html: arg.event.title }; }',
        ];
    }

}
