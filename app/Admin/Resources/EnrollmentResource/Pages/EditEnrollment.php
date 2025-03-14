<?php

namespace App\Admin\Resources\EnrollmentResource\Pages;

use App\Admin\Resources\EnrollmentResource;
use Filament\Actions;
use Filament\Actions\Action;
use App\Models\Enrollment;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditEnrollment extends EditRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        $studentId = $this->data['student_id'];
        $batchProgramId = $this->data['batch_program_id'];
        $recordId = $this->record->id;

        $check_record = Enrollment::where('student_id', $studentId)
                       ->where('batch_program_id', $batchProgramId)
                       ->where('id', '!=', $recordId)
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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
