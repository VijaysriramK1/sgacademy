<?php

namespace App\Admin\Resources\EnrollmentResource\Pages;

use App\Admin\Resources\EnrollmentResource;
use App\Models\Enrollment;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateEnrollment extends CreateRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected function getCreateAnotherFormAction(): Action
    {
    return parent::getCreateAnotherFormAction()->visible(false);
    }

    protected function beforeCreate(): void
    {
        $studentId = $this->data['student_id'];
        $batchProgramId = $this->data['batch_program_id'];

        $check_record = Enrollment::where('student_id', $studentId)
                       ->where('batch_program_id', $batchProgramId)
                       ->exists();

                       if ($check_record) {
                        Notification::make()
                            ->title('Alert Message!')
                            ->danger()
                            ->body('Selected student are already assigned to this batch program. Please choose different batch program.')
                            ->send();
                            $this->halt();
                    }
    }



protected function handleRecordCreation(array $data): Enrollment
{

    if (isset($data['course_ids']) && is_array($data['course_ids'])) {
        $data['course_ids'] = json_encode($data['course_ids']);
    }

    return Enrollment::create($data);
}

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
