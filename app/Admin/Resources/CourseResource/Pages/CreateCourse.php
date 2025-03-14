<?php

namespace App\Admin\Resources\CourseResource\Pages;

use App\Admin\Resources\CourseResource;
use App\Models\Courses;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;
    protected static ?string $title = 'Add Course';

    protected function handleRecordCreation(array $data): Courses {         
        return DB::transaction(function () use ($data) {             
            $institution = DB::table('institutions')->first(); 
            
          
         
            
            $student = Courses::create([
                'name' => $data['name'],
                'course_code' => $data['course_code'] ?? null,
                'course_type' => $data['course_type'],
               
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
