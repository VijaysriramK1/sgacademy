<?php

namespace App\Admin\Resources\ExamTypeResource\Pages;

use App\Admin\Resources\ExamTypeResource;
use App\Models\ExamType;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateExamType extends CreateRecord
{
    protected static string $resource = ExamTypeResource::class;

    protected function handleRecordCreation(array $data): ExamType {         
        return DB::transaction(function () use ($data) {             
            $institution = DB::table('institutions')->first(); 
            
          
         
            
            $student = ExamType::create([
                'title' => $data['title'],
                'is_average' => $data['is_average'] ?? 0,
                'percentage' => $data['percentage'],
                'average_mark' => $data['average_mark'] ?? 0,
                'percantage' => $data['percantage'] ?? 100,
                'status' => $data['status'] ?? 1,
                
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
