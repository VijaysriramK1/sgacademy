<?php

namespace App\Admin\Resources\BatchProgramResource\Pages;

use App\Admin\Resources\BatchProgramResource;
use App\Models\Section;
use App\Models\Program;
use App\Models\Batch;
use App\Models\BatchPrograms;
use Filament\Notifications\Notification;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBatchProgram extends EditRecord
{
    protected static string $resource = BatchProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

  protected function beforeSave(): void
  {
    $batchId = $this->data['batch_id'];
    $programId = $this->data['program_id'];
    $sectionId = $this->data['section_id'];
    $recordId = $this->record->id;

    $check_record = BatchPrograms::where('batch_id', $batchId)
        ->where('program_id', $programId)
        ->where('section_id', $sectionId)
        ->where('id', '!=', $recordId)
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

  protected function afterSave(): void
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
