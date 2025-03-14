<?php

namespace App\User\Resources\CoursesResource\Pages;

use App\Models\Courses;
use App\Models\Lesson;
use App\Models\Topic;
use App\Models\subtopic;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Studentparents;
use App\Helpers\UserHelper;
use Filament\Widgets\Card;
use Filament\Notifications\Notification;
use App\User\Resources\CoursesResource;
use Filament\Panel;
use Filament\Resources\Pages\Page;

class ListCourses extends Page
{
    protected static string $resource = CoursesResource::class;

    protected static string $view = 'user.courses';

    public function getBreadcrumbs(): array
    {
       return [
        '/courses' => 'Courses',
       ];
    }

    public $courses;
    public $students = '';
    public $selectedStudent;

    public function mount()
    {

        $role = UserHelper::currentRole();

        if ($role == 'student') {
            $get_role_based_courses = Enrollment::where('student_id', UserHelper::currentRoleDetails()->id)->first();

            if (!empty($get_role_based_courses)) {

                $this->courses = Courses::whereIn('id', $get_role_based_courses->course_ids)->get();

                foreach ($this->courses as $course) {
                    $course->lesson_count = Lesson::where('course_id', $course->id)->count();
                    $course->topic_count = Topic::whereIn('lesson_id', Lesson::where('course_id', $course->id)->pluck('id'))->count();
                    $course->subtopic_count = subtopic::whereIn('topic_id', Topic::whereIn('lesson_id', Lesson::where('course_id', $course->id)->pluck('id'))->pluck('id'))->count();
                }

            } else {
                $this->courses = '';
            }
        } else {
           $this->students = Student::whereIn('id', Studentparents::where('parent_id', UserHelper::currentRoleDetails()->id)->pluck('student_id'))->get();
           $this->courses = '';
        }

    }


    public function changeStudent()
    {
        if ($this->selectedStudent != '') {

                $this->courses = Courses::whereIn('id', Enrollment::where('student_id', $this->selectedStudent)->value('course_ids'))->get();

                if ($this->courses->isNotEmpty()) {
                    foreach ($this->courses as $course) {
                        $course->lesson_count = Lesson::where('course_id', $course->id)->count();
                        $course->topic_count = Topic::whereIn('lesson_id', Lesson::where('course_id', $course->id)->pluck('id'))->count();
                        $course->subtopic_count = subtopic::whereIn('topic_id', Topic::whereIn('lesson_id', Lesson::where('course_id', $course->id)->pluck('id'))->pluck('id'))->count();
                    }
                } else {
                    $this->courses = '';
                }
        } else {
            $this->courses = '';
        }
    }

    public function viewButtonClick($courseId)
    {
        return redirect("/courses/{$courseId}/details");
    }

    public function getTitle(): string
    {
       return '';
    }

}
