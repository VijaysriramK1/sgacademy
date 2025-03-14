<?php

namespace App\Admin\Resources\SemesterResource\Pages;

use App\Admin\Resources\SemesterResource;
use Filament\Actions;
use App\Models\Semester;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditSemester extends EditRecord
{
    protected static string $resource = SemesterResource::class;

    protected static ?string $title = 'Edit Semesters';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        $semesterName = $this->data['name'];
        $recordId = $this->record->id;
        $check_semester = Semester::where('name', $semesterName)->where('id', '!=', $recordId)->first();

        if (!empty($check_semester)) {
            Notification::make()
            ->title('Alert Message!')
            ->body('This Name has been already there. Please enter different name.')
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
