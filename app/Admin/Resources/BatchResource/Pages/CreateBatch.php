<?php

namespace App\Admin\Resources\BatchResource\Pages;

use App\Admin\Resources\BatchResource;
use App\Models\Batch;
use App\Models\Institution;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateBatch extends CreateRecord
{
    protected static string $resource = BatchResource::class;

    protected static ?string $title = 'Add Batch';

    protected function beforeCreate(): void
    {
        $batchName = $this->data['name'];
        $check_batch = Batch::where('name', $batchName)->first();

        if (!empty($check_batch)) {
            Notification::make()
            ->title('Alert Message!')
            ->body('This Batch has been already created. Please enter different batch.')
            ->danger()
            ->send();
            $this->halt();
        }
    }

    protected function handleRecordCreation(array $data): Batch {
        return DB::transaction(function () use ($data) {
            $institution = DB::table('institutions')->first();




            $student = Batch::create([
                'name' => $data['name'],
                'year' => $data['year'] ?? null,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'] ?? null,
                'status' => $data['status'] ?? null,
                'institution_id' => $institution->id,


            ]);





            return $student;
        });
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
