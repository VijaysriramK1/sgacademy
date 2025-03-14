<?php

namespace App\User\Pages;

use App\Helpers\UserHelper;
use Filament\Pages\Page;
use App\Models\BatchPrograms;
use App\Models\AssignStaffBatchProgram;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'user.dashboard';

    public static ?string $label = 'Dashboard';

    public $role;

    public $batch_program;

    public $selected_batch_program;

    public static function canAccess(): bool
    {
        $role = UserHelper::currentRole();
        if ($role == 'student' || $role == 'parent' || $role == 'staff') {
            return true;
        } else {
            return false;
        }
    }

    public function mount()
    {
        $this->role = UserHelper::currentRole();

        if ($this->role == 'staff') {
            $this->selected_batch_program = Session::get('staff_dashboard_selected_batch_program');
            $this->batch_program = BatchPrograms::whereIn('id', AssignStaffBatchProgram::where('staff_id', UserHelper::currentRoleDetails()->id)->pluck('batch_program_id'))->get();
        }
    }

    public function updateBatchProgram()
    {
        Session::put('staff_dashboard_selected_batch_program', $this->selected_batch_program);
    }

    public function getHeading(): string
    {
        return '';
    }

}
