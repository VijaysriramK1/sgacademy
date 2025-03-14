<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-0">

            <div>
                <h1 class="text-xl font-bold">My Programs</h1>
            </div>

            <div></div>

            <div>
        <x-filament::input.wrapper>
            <x-filament::input.select wire:model="selectedStaff" wire:change="updateStaff()">
                <option value="">Select Staff</option>
                @foreach($staffs as $staff)
                    <option value="{{ $staff->id }}">{{ $staff->first_name }} {{ $staff->last_name }}</option>
                @endforeach
            </x-filament::input.select>
        </x-filament::input.wrapper>

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
        @foreach ($courses as $course)
        <div style="margin-top: 10px;">
            <x-filament::card>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-0">
                <div>
                    <div class="font-bold" style="font-size: 12px;">
                        @if($selectedStaff != '' && $selectedStaff != 'null' && $selectedStaff != 0)
                        <div><span>{{ $course->batch_program ?? 'N/A' }}</span></div> <div>Semester: <span>{{ $course->semester ?? 'N/A' }}</span></div>
                        @else
                        <div>Batch Program: <span>N/A</span></div> <div>Semester: <span>N/A</span></div>
                        @endif
                        <div>Course Name: <span>{{ $course->name }}</span></div>
                    </div>
                    <div style="margin-top: 10px;">
                        <p style="font-size: 10px;"><span>Lessons: {{ $course->lesson_count ?? '0' }}</span>  <span>Topics: {{ $course->topic_count ?? '0' }}</span>  <span>Subtopics: {{ $course->subtopic_count ?? '0' }}</span>
                            @if($selectedStaff != '' && $selectedStaff != 'null' && $selectedStaff != 0)
                               <span>Request: {{ $course->notes ?? 'no message' }}</span>
                            @else
                               <!-- empty -->
                            @endif
                        </p>
                    </div>
                    <div style="margin-top: 10px;">
                        <x-filament::button size="xs" icon="heroicon-o-play" outlined color="info" wire:click="statusClick({{ $course->id }})">View</x-filament::button>
                    </div>
                </div>

                <div></div>

                <div>
                    @if($selectedStaff != '' && $selectedStaff != 'null' && $selectedStaff != 0)
                    <x-filament::input.wrapper>
                        <x-filament::input.select wire:model="selectStatus.{{ $course->id }}" wire:change="updateStatus({{ $course->id }})">
                            <option value="">Select Status</option>
                            <option value="locked" {{ $course->status === 'locked' ? 'selected' : '' }}>Locked</option>
                            <option value="unlocked" {{ $course->status === 'unlocked' ? 'selected' : '' }}>Unlocked</option>
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                    @else
                    <x-filament::input.wrapper>
                        <x-filament::input.select wire:model="selectStatus.{{ $course->id }}" wire:change="updateStatus({{ $course->id }})">
                            <option value="" {{ $course->status === '' ? 'selected' : '' }}>Select Status</option>
                            <option value="locked">Locked</option>
                            <option value="unlocked">Unlocked</option>
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                    @endif
                </div>
            </div>
            </x-filament::card>
             </div>
        @endforeach
    @endif
</x-filament::page>
