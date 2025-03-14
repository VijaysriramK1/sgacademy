<?php

namespace App\Admin\Resources\GradeResource\Pages;

use App\Admin\Resources\GradeResource;
use App\Models\Grade;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateGrade extends CreateRecord
{
    protected static string $resource = GradeResource::class;

    protected function handleRecordCreation(array $data): Grade {         
        return DB::transaction(function () use ($data) {             
            $institution = DB::table('institutions')->first(); 
            
          
         
            
            $student = Grade::create([
                'name' => $data['name'],
                'status' => $data['status'] ?? 0 ,
                'description' => $data['description'],
                
                'institution_id' => $institution->id,
                
              
            ]);                  
            
           
          
          
            
            return $student;
        });     
    }

}
