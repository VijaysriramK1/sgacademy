<?php

namespace App\Admin\Resources\MyProgramsResource\Pages;

use App\Models\Staff;
use App\Models\Courses;
use App\Models\Lesson;
use App\Models\Topic;
use App\Models\subtopic;
use App\Models\Semester;
use App\Models\AssignCourse;
use App\Models\BatchPrograms;
use Filament\Widgets\Card;
use Filament\Notifications\Notification;
use App\Models\AssignStaffBatchProgram;
use App\Admin\Resources\MyProgramsResource;
use Filament\Resources\Pages\Page;

class MyPrograms extends Page
{
    protected static string $resource = MyProgramsResource::class;

    protected static string $view = 'admin.myprograms';

    public function getBreadcrumbs(): array
    {
       return [
        '/admin/my-programs' => 'My Programs',
       ];
    }

    public $staffs;
    public $courses;
    public $selectedStaff;
    public $selectStatus = [];

    public function mount()
    {
        $this->staffs = Staff::get();
        $this->loadCourses();
    }

    protected function loadCourses()
    {
        $this->courses = Courses::get();

        foreach ($this->courses as $course) {
            $course->lesson_count = Lesson::where('course_id', $course->id)->count();
            $course->topic_count = Topic::whereIn('lesson_id', Lesson::where('course_id', $course->id)->pluck('id'))->count();
            $course->subtopic_count = subtopic::whereIn('topic_id', Topic::whereIn('lesson_id', Lesson::where('course_id', $course->id)->pluck('id'))->pluck('id'))->count();
        }
    }

    public function updateStaff()
    {
        if ($this->selectedStaff != '' && $this->selectedStaff != 0 && $this->selectedStaff != 'null') {
            $get_staff_based_courses = AssignCourse::where('staff_id', $this->selectedStaff)->orderBy('assign_staff_batch_program_id', 'asc')->get();

            if ($get_staff_based_courses->isEmpty()) {
                $this->courses = [];
            } else {
                $this->courses = Courses::whereIn('id', $get_staff_based_courses->pluck('course_id'))->get();

                foreach ($this->courses as $course) {
                    $get_status = $get_staff_based_courses->where('staff_id', $this->selectedStaff)->where('course_id', $course->id)->first();
                    $course->status = $get_status->status;
                    $course->notes = $get_status->notes;
                    $course->batch_program = BatchPrograms::where('id', AssignStaffBatchProgram::where('id', $get_status->assign_staff_batch_program_id)->value('batch_program_id'))->value('batch_group');
                    $course->semester = Semester::where('id', AssignStaffBatchProgram::where('id', $get_status->assign_staff_batch_program_id)->value('semester_id'))->value('name');
                }
            }
        } else {
            $this->selectedStaff = '';
            $this->courses = Courses::get();
        }
    }

    public function updateStatus($courseId)
    {
        if ($this->selectedStaff != '' && $this->selectedStaff != 0 && $this->selectedStaff != 'null') {

            $check_course = AssignCourse::where('staff_id', $this->selectedStaff)->where('course_id', $courseId)->first();
            if (!empty($check_course)) {
                AssignCourse::where('id', $check_course->id)->update(['status' => $this->selectStatus[$courseId], 'notes' => 'no message']);
            } else {
                $user = AssignCourse::create([
                    'staff_id' => $this->selectedStaff,
                    'course_id' => $courseId,
                    'status' => $this->selectStatus[$courseId],
                    'notes' => 'no message'
                ]);
            }
            Notification::make()
            ->title('Message')
            ->body('Status Updated Successfully.')
            ->success()
            ->send();

            $this->updateStaff();

        } else {
            Notification::make()
            ->title('Alert')
            ->body('Please Select Staff!')
            ->danger()
            ->send();
        }
    }


    public function statusClick($courseId)
    {
        return redirect("/admin/my-programs/{$courseId}/details");
    }


    public function getTitle(): string
    {
       return '';
    }

}
