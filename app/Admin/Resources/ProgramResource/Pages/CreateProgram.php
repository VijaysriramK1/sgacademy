<?php

namespace App\Admin\Resources\ProgramResource\Pages;

use App\Admin\Resources\ProgramResource;
use App\Models\Program;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class CreateProgram extends CreateRecord
{
    protected static string $resource = ProgramResource::class;


    protected function beforeCreate(): void
    {
        $programName = $this->data['name'];
        $programCode = $this->data['program_code'];
        $check_program = Program::where('name', $programName)->first();

        if (!empty($check_program)) {
            Notification::make()
            ->title('Alert Message!')
            ->body('This program name has been already created. Please enter different program name.')
            ->danger()
            ->send();
            $this->halt();
            return;
        }

        $check_program_code = Program::where('program_code', $programCode)->exists();

        if ($check_program_code) {
            Notification::make()
                ->title('Alert Message!')
                ->body('This Branch Code are already assigned to another program. Please enter different code.')
                ->danger()
                ->send();
            $this->halt();
        }
    }

    protected function handleRecordCreation(array $data): Program {
        return DB::transaction(function () use ($data) {
            $institution = DB::table('institutions')->first();




            $student = Program::create([

                'name' => $data['name'] ?? null,
                'program_code' => $data['program_code'] ?? null,
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
