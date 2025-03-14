<?php

namespace App\Admin\Resources\BatchProgramResource\Pages;

use App\Admin\Resources\BatchProgramResource;
use App\Models\Section;
use App\Models\Program;
use App\Models\Batch;
use App\Models\BatchPrograms;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateBatchProgram extends CreateRecord
{
    protected static string $resource = BatchProgramResource::class;

    protected function getCreateAnotherFormAction(): Action
    {
    return parent::getCreateAnotherFormAction()->visible(false);
    }

    protected function beforeCreate(): void
    {
        $batchId = $this->data['batch_id'];
        $programId = $this->data['program_id'];
        $sectionId = $this->data['section_id'];

        $check_record = BatchPrograms::where('batch_id', $batchId)
                       ->where('program_id', $programId)
                       ->where('section_id', $sectionId)
                       ->exists();

                       if ($check_record) {
                        Notification::make()
                            ->title('Record Already Exists')
                            ->danger()
                            ->body('A record with the same batch, program, and section already exists.')
                            ->send();
                            $this->halt();
                    }
    }

    protected function handleRecordCreation(array $data): BatchPrograms {
        return DB::transaction(function () use ($data) {
            $institution = DB::table('institutions')->first();




            $student = BatchPrograms::create([
                'batch_id' => $data['batch_id'],
                'program_id' => $data['program_id'] ?? null,
                'section_id' => $data['section_id'],
                'semester_id' => $data['semester_id'] ?? null,
                'status' => $data['status'] ?? null,
                'institution_id' => $institution->id,


            ]);





            return $student;
        });
    }

    protected function afterCreate(): void
    {
        $batch = Batch::where('id', $this->record->batch_id)->value('name');
        $program = Program::where('id', $this->record->program_id)->value('name');
        $section = Section::where('id', $this->record->section_id)->value('name');
        $batch_group = 'Batch: (' . $batch . ') Program: (' . $program . ') Section: (' . $section . ')';

        BatchPrograms::where('id', $this->record->id)->update([
            'batch_group' => $batch_group,
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
