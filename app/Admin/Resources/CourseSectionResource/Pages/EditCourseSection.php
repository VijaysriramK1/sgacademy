<?php

namespace App\Admin\Resources\CourseSectionResource\Pages;

use App\Admin\Resources\CourseSectionResource;
use Filament\Actions;
use App\Models\CourseSection;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCourseSection extends EditRecord
{
    protected static string $resource = CourseSectionResource::class;

    public function getBreadcrumbs(): array
    {
      $record_id = request()->route('record');
      return [
        '#' => 'Assign Course',
        '/admin/course-sections/' . $record_id . '/edit' => 'Edit',
      ];
    }

    public function getHeading(): string
    {
        return 'Assign Course';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function beforeSave(): void
    {
        $batchProgramId = $this->data['batch_program_id'];
        $semesterId = $this->data['semester_id'];
        $recordId = $this->record->id;
        $check_details = CourseSection::where('batch_program_id', $batchProgramId)->where('semester_id', $semesterId)->where('id', '!=', $recordId)->exists();

        if ($check_details) {
            Notification::make()
                ->title('Alert Message!')
                ->body('Selected batch program & semester are already assigned to courses. Please choose different batch program or semester.')
                ->danger()
                ->send();
            $this->halt();
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
