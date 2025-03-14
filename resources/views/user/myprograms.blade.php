<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-0">
        <div>
            <h1 class="text-xl font-bold">My Programs</h1>
        </div>

        <div></div>

        <div></div>

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
        @foreach ($courses as $course)
        <div style="margin-top: 10px;">
            <x-filament::card>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-0">
                <div>
                    <div class="font-bold" style="font-size: 12px;">
                        <div><span>{{ $course->batch_program ?? 'N/A' }}</span></div> <div>Semester: <span>{{ $course->semester ?? 'N/A' }}</span></div> <div>Course Name: <span>{{ $course->name }}</span></div>
                    </div>

                    <div style="margin-top: 10px;">
                        <p style="font-size: 10px;"><span>Lessons: {{ $course->lesson_count ?? '0' }}</span>  <span>Topics: {{ $course->topic_count ?? '0' }}</span>  <span>Subtopics: {{ $course->subtopic_count ?? '0' }}</span></p>
                    </div>

                    <div style="margin-top: 10px;">
                            @if($course->status == 'unlocked')
                            <x-filament::button size="xs" icon="heroicon-o-play" outlined tooltip="Unlocked" color="info" wire:click="statusClick({{ $course->id }})">View</x-filament::button>
                            @else
                            <x-filament::button size="xs" icon="heroicon-o-lock-closed" outlined tooltip="Locked" color="warning" wire:click="statusClick({{ $course->id }})">Locked</x-filament::button>
                            @endif
                    </div>
                </div>

                <div></div>

                <div>
                    <x-filament::input.wrapper>
                        <x-filament::input.select wire:model="selectStatus.{{ $course->id }}" wire:change="updateStatus({{ $course->id }})">
                            <option value="">Send Request</option>
                            <option value="locked" {{ $course->status === 'locked' ? 'selected' : '' }}>Locked</option>
                            <option value="unlocked" {{ $course->status === 'unlocked' ? 'selected' : '' }}>Unlocked</option>
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                </div>
            </div>
            </x-filament::card>
             </div>
        @endforeach
    @endif
</x-filament::page>
