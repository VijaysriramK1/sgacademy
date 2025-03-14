<?php

namespace App\Admin\Resources\AssignStaffBatchProgramsResource\Pages;

use App\Admin\Resources\AssignStaffBatchProgramsResource;
use Filament\Actions;
use Filament\Actions\Action;
use App\Models\AssignCourse;
use App\Models\AssignStaffBatchProgram;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateAssignStaffBatchPrograms extends CreateRecord
{
    protected static string $resource = AssignStaffBatchProgramsResource::class;

    protected function getCreateAnotherFormAction(): Action
    {
    return parent::getCreateAnotherFormAction()->visible(false);
    }

    public function getBreadcrumbs(): array
    {
      return [
        '#' => 'Assign Staff',
        '/admin/assign-staff-batch-programs/create' => 'Create',
      ];
    }


    public function getHeading(): string
    {
        return 'Assign Staff';
    }


    protected function beforeCreate(): void
    {
        $staffId = $this->data['staff_id'];
        $batchProgramId = $this->data['batch_program_id'];
        $semesterId = $this->data['semester_id'];

        $check_record = AssignStaffBatchProgram::where('staff_id', $staffId)->where('batch_program_id', $batchProgramId)->where('semester_id', $semesterId)->exists();

        if ($check_record) {
            Notification::make()
              ->title('Alert Message!')
              ->body('This staff member has already been assigned to the selected batch program & semester. Please choose a different batch program or semester.')
              ->danger()
              ->send();
              $this->halt();
        }
    }

    protected function afterCreate(): void
    {
        $data = $this->record;
        $get_course_ids = is_array($data->course_id) ? $data->course_id : explode(',', $data->course_id);
            $dataToInsert = [];
               foreach ($get_course_ids as $course_id) {
                    $dataToInsert[] = [
                        'staff_id' => $data->staff_id,
                        'course_id' => $course_id,
                        'status' => 'unlocked',
                        'assign_staff_batch_program_id' => $data->id,
                    ];
                }

                AssignCourse::insert($dataToInsert);
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}


