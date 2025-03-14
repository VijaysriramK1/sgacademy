<?php

namespace App\Admin\Resources\GradeSetupResource\Pages;

use App\Admin\Resources\GradeSetupResource;
use App\Models\GradeSetup;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateGradeSetup extends CreateRecord
{
    protected static string $resource = GradeSetupResource::class;

    protected function handleRecordCreation(array $data): GradeSetup {         
        return DB::transaction(function () use ($data) {             
                 
            $student = GradeSetup::create([
                'grade_id' => $data['grade_id'],
                'name' => $data['name'] ?? 0 ,
                'gpa' => $data['gpa'],
                'min_mark' => $data['min_mark'],
                'max_mark' => $data['max_mark'],
                'min_percent' => $data['min_percent'],
                'max_percent' => $data['max_percent'],
                'status' => $data['status'],
                'description' => $data['description'],
             
            ]);                  
            
            return $student;
        });    
    } 
}
