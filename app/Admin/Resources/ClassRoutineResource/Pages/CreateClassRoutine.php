<?php

namespace App\Admin\Resources\ClassRoutineResource\Pages;

use App\Models\Routine;
use App\Admin\Resources\ClassRoutineResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateClassRoutine extends CreateRecord
{
    protected static string $resource = ClassRoutineResource::class;

    public function getBreadcrumbs(): array
    {
       return [
        '#' => 'Class Routine',
        '/admin/class-routines/create' => 'Create',
       ];
    }

    protected function getCreateAnotherFormAction(): Action
    {
    return parent::getCreateAnotherFormAction()->visible(false);
    }

    protected function afterCreate(): void
    {
        $data = $this->record;
        $selectedDays = is_array($data->day) ? $data->day : explode(',', $data->day);
        $dataToInsert = [];

        foreach ($selectedDays as $day) {
            $encodedTopicId = is_array($data->topic_id) ? json_encode($data->topic_id) : $data->topic_id;
            $dataToInsert[] = [
                'staff_id' => $data->staff_id,
                'batch_program_id' => $data->batch_program_id,
                'semester_id' => $data->semester_id,
                'course_id' => $data->course_id,
                'lesson_id' => $data->lesson_id,
                'topic_id' => $encodedTopicId,
                'day' => $day,
                'start_date' => $data->start_date,
                'end_date' => $data->end_date,
                'start_time' => $data->start_time,
                'end_time' => $data->end_time,
            ];
        }

        Routine::insert($dataToInsert);
        Routine::where('id', $data->id)->delete();

    }

    protected function getRedirectUrl(): string
    {
      return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string
    {
       return 'Class Routine Create';
    }
}
