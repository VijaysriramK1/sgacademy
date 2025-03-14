<?php

namespace App\Admin\Resources\StudentgroupResource\Pages;

use App\Admin\Resources\StudentgroupResource;
use App\Models\Institution;
use App\Models\Studentgroup;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateStudentgroup extends CreateRecord
{
    protected static string $resource = StudentgroupResource::class;

    protected function handleRecordCreation(array $data): Studentgroup {    
             
        return DB::transaction(function () use ($data) {    

            $institution = Institution::findOrFail(1);

            $studentgroup = Studentgroup::create([
                'name' => $data['name'],
                'institution_id' => $institution->id,
                'status' => $data['status'] 
            ]);

            return $studentgroup;
        });
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
