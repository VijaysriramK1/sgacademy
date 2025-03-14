<?php

namespace App\Admin\Resources\ExamResource\Pages;

use App\Admin\Resources\ExamResource;
use App\Models\Exam;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateExam extends CreateRecord
{
    protected static string $resource = ExamResource::class;

    protected function handleRecordCreation(array $data): Exam {         
        return DB::transaction(function () use ($data) {             
            $institution = DB::table('institutions')->first(); 
            
          
         
            
            $student = Exam::create([
                'exam_type_id' => $data['exam_type_id'],
                'total_mark' => $data['total_mark'] ?? 0 ,
                'pass_mark' => $data['pass_mark'],
                'date' => $data['date'] ,
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'] ,
                'staff_id' => $data['staff_id'],
                'status' => $data['status'] ?? 1,
                'program_id' => $data['program_id'],
                'semester_id' => $data['semester_id'],
                'course_id' => $data['course_id'] ,
                'section_id' => $data['section_id'] ,
                'batch_id' => $data['batch_id'] ,
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
