<?php

namespace App\Admin\Resources\SemesterResource\Pages;

use App\Admin\Resources\SemesterResource;
use App\Models\Semester;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateSemester extends CreateRecord
{
    protected static string $resource = SemesterResource::class;

    protected function beforeCreate(): void
    {
        $semesterName = $this->data['name'];
        $check_semester = Semester::where('name', $semesterName)->first();

        if (!empty($check_semester)) {
            Notification::make()
            ->title('Alert Message!')
            ->body('This Name has been already created. Please enter different name.')
            ->danger()
            ->send();
            $this->halt();
        }
    }


    protected function handleRecordCreation(array $data): Semester {
        return DB::transaction(function () use ($data) {
            $institution = DB::table('institutions')->first();




            $student = Semester::create([

                'name' => $data['name'] ?? null,
                'year' => $data['year'] ?? null,
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
