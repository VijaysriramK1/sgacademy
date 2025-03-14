<?php

namespace App\User\Resources\MyProgramsResource\Pages;

use App\Models\Staff;
use App\Models\Courses;
use App\Models\Lesson;
use App\Models\Topic;
use App\Models\subtopic;
use App\Models\AssignCourse;
use App\Models\Semester;
use App\Models\BatchPrograms;
use App\Models\AssignStaffBatchProgram;
use App\Helpers\UserHelper;
use Filament\Widgets\Card;
use Filament\Notifications\Notification;
use App\User\Resources\MyProgramsResource;
use Filament\Panel;
use Filament\Resources\Pages\Page;

class MyPrograms extends Page
{
    protected static string $resource = MyProgramsResource::class;

    protected static string $view = 'user.myprograms';

    public function getBreadcrumbs(): array
    {
       return [
        '/my-programs' => 'My Programs',
       ];
    }

    public $courses;
    public $selectStatus = [];

    public function mount()
    {
        $this->loadCourses();
    }

    protected function loadCourses()
    {
        $get_role_based_courses = AssignCourse::where('staff_id', UserHelper::currentRoleDetails()->id)->get();
        $get_courses = Courses::whereIn('id', $get_role_based_courses->pluck('course_id'))->get();

        if (!$get_courses->isEmpty()) {
            $this->courses = $get_courses;
            foreach ($this->courses as $course) {
                $course->lesson_count = Lesson::where('course_id', $course->id)->count();
                $course->topic_count = Topic::whereIn('lesson_id', Lesson::where('course_id', $course->id)->pluck('id'))->count();
                $course->subtopic_count = subtopic::whereIn('topic_id', Topic::whereIn('lesson_id', Lesson::where('course_id', $course->id)->pluck('id'))->pluck('id'))->count();
                $course->status = AssignCourse::where('staff_id', UserHelper::currentRoleDetails()->id)->where('course_id', $course->id)->first()->status;
                $course->batch_program = BatchPrograms::where('id', AssignStaffBatchProgram::where('id', AssignCourse::where('staff_id', UserHelper::currentRoleDetails()->id)->where('course_id', $course->id)->value('assign_staff_batch_program_id'))->value('batch_program_id'))->value('batch_group');
                $course->semester = Semester::where('id', AssignStaffBatchProgram::where('id', AssignCourse::where('staff_id', UserHelper::currentRoleDetails()->id)->where('course_id', $course->id)->value('assign_staff_batch_program_id'))->value('semester_id'))->value('name');
            }

        } else {
            $this->courses = '';
        }

    }


    public function updateStatus($courseId)
    {
        $check_course = AssignCourse::where('staff_id', UserHelper::currentRoleDetails()->id)->where('course_id', $courseId)->first();
        AssignCourse::where('id', $check_course->id)->update(['notes' => $this->selectStatus[$courseId]]);

        Notification::make()
            ->title('Message')
            ->body('Request successfully sended to admin.')
            ->success()
            ->send();

            $this->loadCourses();
    }

    public function statusClick($courseId)
    {
        $check_course = AssignCourse::where('staff_id', UserHelper::currentRoleDetails()->id)->where('course_id', $courseId)->value('status');

        if ($check_course == 'unlocked') {
            return redirect("/my-programs/{$courseId}/details");
        } else {
            Notification::make()
            ->title('Alert!')
            ->body('Course are locked.')
            ->danger()
            ->send();

            $this->loadCourses();
        }

    }

    public function getTitle(): string
    {
       return '';
    }

}
