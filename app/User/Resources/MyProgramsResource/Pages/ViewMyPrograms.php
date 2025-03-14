<?php

namespace App\User\Resources\MyProgramsResource\Pages;

use App\Models\Courses;
use App\Models\Lesson;
use App\Models\Topic;
use App\Models\subtopic;
use App\User\Resources\MyProgramsResource;
use Filament\Resources\Pages\Page;

class ViewMyPrograms extends Page
{
    protected static string $resource = MyProgramsResource::class;

    protected static string $view = 'user.viewmyprograms';

    public $changeTab = 'Courses';

    public $course;
    public $lessons;
    public $topics;
    public $subtopics;
    public $record_id;

    public function mount()
    {
        $this->record_id = request()->route('record');
        $this->course = Courses::where('id', request()->route('record'))->first();
        $this->lessons = Lesson::where('course_id', request()->route('record'))->get();
        $this->topics = Topic::whereIn('lesson_id', Lesson::where('course_id', request()->route('record'))->pluck('id'))->orderBy('lesson_id', 'asc')->get();
        $this->subtopics = subtopic::whereIn('topic_id', Topic::whereIn('lesson_id', Lesson::where('course_id', request()->route('record'))->pluck('id'))->pluck('id'))->orderBy('topic_id', 'asc')->get();
    }

    public function tabClick($data)
    {
       $this->changeTab = $data;
    }


    public function getTitle(): string
    {
       return '';
    }

}
