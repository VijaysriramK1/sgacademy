<?php

namespace app\Admin\Resources\CourseSectionResource\Pages;

use app\Admin\Resources\CourseSectionResource;
use App\Models\CourseSection;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateCourseSection extends CreateRecord
{
    protected static string $resource = CourseSectionResource::class;

    protected function getCreateAnotherFormAction(): Action
    {
    return parent::getCreateAnotherFormAction()->visible(false);
    }

    public function getBreadcrumbs(): array
    {
      return [
        '#' => 'Assign Course',
        '/admin/course-sections/create' => 'Create',
      ];
    }

    public function getHeading(): string
    {
        return 'Assign Course';
    }

    protected function beforeCreate(): void
    {
        $batchProgramId = $this->data['batch_program_id'];
        $semesterId = $this->data['semester_id'];
        $check_details = CourseSection::where('batch_program_id', $batchProgramId)->where('semester_id', $semesterId)->exists();

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
