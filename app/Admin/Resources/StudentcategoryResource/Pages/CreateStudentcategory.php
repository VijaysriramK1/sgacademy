<?php

namespace App\Admin\Resources\StudentcategoryResource\Pages;

use App\Admin\Resources\StudentcategoryResource;
use App\Models\Institution;
use App\Models\Studentcategory;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateStudentcategory extends CreateRecord
{
    protected static string $resource = StudentcategoryResource::class;

    protected function handleRecordCreation(array $data): Studentcategory {     

        return DB::transaction(function () use ($data) {    

            $institution = Institution::findOrFail(1);

            $studentgroup = Studentcategory::create([
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
