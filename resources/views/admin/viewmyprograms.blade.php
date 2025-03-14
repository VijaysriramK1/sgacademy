<x-filament::page>

<div>
    <h1 class="text-xl font-bold">My Program Details</h1>
</div>

<x-filament::tabs x-data="{ activeTab: 'Courses' }">
    <x-filament::tabs.item alpine-active="activeTab === 'Courses'" x-on:click="activeTab = 'Courses'" wire:click="tabClick('Courses')" icon="heroicon-o-academic-cap" icon-position="after">Courses</x-filament::tabs.item>
    <x-filament::tabs.item alpine-active="activeTab === 'Lessons'" x-on:click="activeTab = 'Lessons'" wire:click="tabClick('Lessons')" icon="heroicon-o-book-open" icon-position="after">Lessons</x-filament::tabs.item>
    <x-filament::tabs.item alpine-active="activeTab === 'Topics'" x-on:click="activeTab = 'Topics'" wire:click="tabClick('Topics')" icon="heroicon-o-document-text" icon-position="after">Topics</x-filament::tabs.item>
    <x-filament::tabs.item alpine-active="activeTab === 'Subtopics'" x-on:click="activeTab = 'Subtopics'" wire:click="tabClick('Subtopics')" icon="heroicon-o-clipboard" icon-position="after">SubTopics</x-filament::tabs.item>
</x-filament::tabs>

@if($changeTab == 'Courses')
<x-filament::section>
    <x-slot name="heading">
        Course Details
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-0">

        <div>
            <label>Course Name</label>
            <x-filament::input.wrapper style="margin-top: 10px;">
                <x-filament::input type="text" value="{{ $course->name ?? '' }}" readonly />
            </x-filament::input.wrapper>

            <div style="margin-top: 30px;">
                <label>Course Type</label>
                <x-filament::input.wrapper style="margin-top: 10px;">
                    <x-filament::input type="text" value="{{ $course->course_type ?? '' }}" readonly />
                </x-filament::input.wrapper>

            </div>
 

        </div>
        <div>
            <label>Course Code</label>
            <x-filament::input.wrapper style="margin-top: 10px;">
                <x-filament::input type="text" value="{{ $course->course_code ?? '' }}" readonly />
            </x-filament::input.wrapper>
        </div>

    </div>



</x-filament::section>
@elseif($changeTab == 'Lessons')
<x-filament::section>
    <x-slot name="heading">
        Lesson Details
    </x-slot>

    @foreach ($lessons as $index => $lesson)
    <label>Lesson No:</label>  <span>{{ $index + 1 }}</span>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-0" style="margin-top: 20px; margin-bottom: 20px;">
        <div>
            <label>Title</label>
            <x-filament::input.wrapper style="margin-top: 10px;">
                <x-filament::input type="text" value="{{ $lesson->title ?? '' }}" readonly />
            </x-filament::input.wrapper>
        </div>
        <div>
            <label>Content</label>
            <x-filament::input.wrapper style="margin-top: 10px;">
                <x-filament::input type="text" value="{{ $lesson->content ?? '' }}" readonly />
            </x-filament::input.wrapper>
        </div>
    </div>

    @endforeach

</x-filament::section>
@elseif($changeTab == 'Topics')
<x-filament::section>
    <x-slot name="heading">
        Topic Details
    </x-slot>

    @foreach ($topics->groupBy('lesson_id') as $lessonId => $lessonTopics)
    @php
        $lessonName = $lessons->firstWhere('id', $lessonId)?->title ?? '';
    @endphp

@foreach ($lessonTopics as $index => $topic)
    <p><label>Lesson Name:</label>  <span>{{ $lessonName }}</span>    <span style="margin-left: 30px;"><label>Topic No:</label>  <span>{{ $index + 1 }}</span></span></p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-0" style="margin-top: 20px; margin-bottom: 20px;">
        <div>
            <label>Title</label>
            <x-filament::input.wrapper style="margin-top: 10px;">
                <x-filament::input type="text" value="{{ $topic->title ?? '' }}" readonly />
            </x-filament::input.wrapper>
        </div>
        <div>
            <label>Content</label>
            <x-filament::input.wrapper style="margin-top: 10px;">
                <x-filament::input type="text" value="{{ $topic->content ?? '' }}" readonly />
            </x-filament::input.wrapper>
        </div>
    </div>
    @endforeach
    @endforeach
</x-filament::section>
@elseif($changeTab == 'Subtopics')
<x-filament::section>
    <x-slot name="heading">
        Subtopic Details
    </x-slot>

@foreach ($subtopics->groupBy('topic_id') as $topicId => $topicBasedSubtopics)
@php
$topic = $topics->firstWhere('id', $topicId);
@endphp
@foreach ($topicBasedSubtopics as $index => $subtopic)
<p><label>Topic Name:</label>  <span>{{ $topic->title ?? '' }}</span>   <span style="margin-left: 30px;"><label>Subtopic No:</label>  <span>{{ $index + 1 }}</span></span></p>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-0" style="margin-top: 20px; margin-bottom: 20px;">
    <div>
        <label>Title</label>
        <x-filament::input.wrapper style="margin-top: 10px;">
            <x-filament::input type="text" value="{{ $subtopic->title ?? '' }}" readonly />
        </x-filament::input.wrapper>
    </div>
    <div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-0">

            <div>
                <label>Maximum Mark</label>
                <div style="margin-top: 10px;">
                <x-filament::button size="sm" color="info" outlined>{{ $subtopic->max_marks ?? '100' }}</x-filament::button>
                </div>
            </div>

            <div>
                <label>Average Mark</label>
                <div style="margin-top: 10px;">
                <x-filament::button size="sm" color="info" outlined>{{ $subtopic->avg_marks ?? '50' }}</x-filament::button>
                </div>
            </div>

        </div>
    </div>
</div>
@endforeach
@endforeach
</x-filament::section>
@else
 <!-- empty -->
@endif


</x-filament::page>


