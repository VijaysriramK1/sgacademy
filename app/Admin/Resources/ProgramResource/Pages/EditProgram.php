<?php

namespace App\Admin\Resources\ProgramResource\Pages;

use App\Admin\Resources\ProgramResource;
use Filament\Actions;
use App\Models\Program;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditProgram extends EditRecord
{
    protected static string $resource = ProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        $programName = $this->data['name'];
        $programCode = $this->data['program_code'];
        $recordId = $this->record->id;
        $check_program = Program::where('name', $programName)->where('id', '!=', $recordId)->first();

        if (!empty($check_program)) {
            Notification::make()
            ->title('Alert Message!')
            ->body('This program name has been already created. Please enter different program name.')
            ->danger()
            ->send();
            $this->halt();
            return;
        }

        $check_program_code = Program::where('program_code', $programCode)->where('id', '!=', $recordId)->exists();

        if ($check_program_code) {
            Notification::make()
                ->title('Alert Message!')
                ->body('This Branch Code are already assigned to another program. Please enter different code.')
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
