<x-filament::page>
    @if($role == 'staff')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-0">
        <div>
            <h1 class="text-xl font-bold">Welcome to Staff Dashboard</h1>
        </div>

        <div></div>

        <div>
          <x-filament::input.wrapper>
             <x-filament::input.select wire:model="selected_batch_program" wire:change="updateBatchProgram()">
                <option value="">Select Batch Program</option>
                  @foreach($batch_program as $program)
                   <option value="{{ $program->id }}" {{ $selected_batch_program == $program->id ? 'selected' : '' }}>{{ $program->batch_group }}</option>
                  @endforeach
             </x-filament::input.select>
           </x-filament::input.wrapper>
        </div>

    </div>

    <div>
        @livewire(\App\User\Resources\DashboardResource\Widgets\StaffStatsOverview::class)
    </div>

    <div>
        @livewire(\App\User\Resources\DashboardResource\Widgets\StaffCalendar::class)
    </div>

    @elseif($role == 'student')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-0">

        <div>
            <h1 class="text-xl font-bold">Welcome to Student Dashboard</h1>
        </div>

        <div></div>

        <div></div>

    </div>

    <div>
        @livewire(\App\User\Resources\DashboardResource\Widgets\StudentStatsOverview::class)
    </div>

    @elseif($role == 'parent')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-0">

        <div>
            <h1 class="text-xl font-bold">Welcome to Parent Dashboard</h1>
        </div>

        <div></div>

        <div></div>

    </div>

    <div>
        @livewire(\App\User\Resources\DashboardResource\Widgets\ParentStatsOverview::class)
    </div>

    @else
      <!-- empty -->
    @endif

</x-filament::page>



