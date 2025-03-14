<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-0">
        <div>
            <h1 class="text-xl font-bold">Courses</h1>
        </div>

        <div></div>

        <div>
            @if (!empty($students))
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model="selectedStudent" wire:change="changeStudent()">
                    <option value="">Select Student</option>
                    @foreach ($students as $student)
                      <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                   @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
            @else
            <!-- empty -->
            @endif
        </div>

    </div>

    @if (empty($courses))
    <div style="margin-top: 10px;">
    <x-filament::card>
        <div class="text-center text-gray-600">
            <p>No records found.</p>
        </div>
    </x-filament::card>
</div>

    @else
        <div style="margin-top: 10px;">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-0">
                @foreach ($courses as $course)
                <div>
                    <x-filament::card>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-0">
                        <div>
                            <div class="font-bold">{{ $course->name }}</div>
                            <div style="margin-top: 10px;">
                                <p style="font-size: 10px;"><span>Lessons: {{ $course->lesson_count ?? '0' }}</span>  <span>Topics: {{ $course->topic_count ?? '0' }}</span>  <span>Subtopics: {{ $course->subtopic_count ?? '0' }}</span></p>
                            </div>

                            <div style="margin-top: 20px;">
                                <x-filament::button size="xs" icon="heroicon-o-play" outlined tooltip="View" color="info" wire:click="viewButtonClick({{ $course->id }})">View</x-filament::button>
                            </div>
                        </div>

                    </div>
                    </x-filament::card>
                </div>

                @endforeach

            </div>

             </div>
    @endif
</x-filament::page>
