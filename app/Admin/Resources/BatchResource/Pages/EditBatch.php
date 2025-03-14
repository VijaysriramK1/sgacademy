<?php

namespace App\Admin\Resources\BatchResource\Pages;

use App\Admin\Resources\BatchResource;
use Filament\Actions;
use App\Models\Batch;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditBatch extends EditRecord
{
    protected static string $resource = BatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        $batchName = $this->data['name'];
        $recordId = $this->record->id;
        $check_batch = Batch::where('name', $batchName)->where('id', '!=', $recordId)->first();

        if (!empty($check_batch)) {
            Notification::make()
            ->title('Alert Message!')
            ->body('This Batch has been already there. Please enter different batch.')
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
