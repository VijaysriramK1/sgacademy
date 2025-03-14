<?php

namespace App\Admin\Resources\AssignScholarshipResource\Pages;

use App\Admin\Resources\AssignScholarshipResource;
use Filament\Notifications\Notification;
use App\Models\StudentScholarship;
use App\Models\Stipend;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateAssignScholarship extends CreateRecord
{
    protected static string $resource = AssignScholarshipResource::class;

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()->visible(false);
    }

    public function getBreadcrumbs(): array
    {
      return [
        '#' => 'Assign Scholarship',
        '/admin/assign-scholarships/create' => 'Create',
      ];
    }

    public function getHeading(): string
    {
        return 'Assign Scholarship';
    }

    protected function beforeCreate(): void
    {
        $scholarshipId = $this->data['scholarship_id'];
        $batchProgramId = $this->data['batch_program_id'];
        $selectedStudents = is_array($this->data['student_id']) ? $this->data['student_id'] : explode(',', $this->data['student_id']);

        $existingRecords = StudentScholarship::where('scholarship_id', $scholarshipId)->where('batch_program_id', $batchProgramId)->whereIn('student_id', $selectedStudents)->get();

        if ($existingRecords->isNotEmpty()) {
            Notification::make()
                ->title('Alert Message!')
                ->body('Some of the selected students are already added to this scholarship.')
                ->danger()
                ->send();
            $this->halt();
        }

    }

    protected function afterCreate(): void
    {
        $data = $this->record;
        $selectedStudents = is_array($data->student_id) ? $data->student_id : explode(',', $data->student_id);
        $dataToInsert = [];

        foreach ($selectedStudents as $value) {
            $studentScholarshipId = StudentScholarship::insertGetId([
                'scholarship_id' => $data->scholarship_id,
                'batch_program_id' => $data->batch_program_id,
                'student_id' => $value,
                'amount' => $data->amount,
                'stipend_amount' => $data->stipend_amount,
                'awarded_date' => $data->awarded_date,
            ]);

            $dataToInsert[] = [
                'student_scholarship_id' => $studentScholarshipId,
                'scholarship_id' => $data->scholarship_id,
                'batch_program_id' => $data->batch_program_id,
                'student_id' => $value,
                'amount' => $data->stipend_amount,
                'start_date' => $data->awarded_date,
            ];
        }

        Stipend::insert($dataToInsert);
        StudentScholarship::where('id', $data->id)->delete();

    }

    protected function getRedirectUrl(): string
    {
    return $this->getResource()::getUrl('index');
    }
}
