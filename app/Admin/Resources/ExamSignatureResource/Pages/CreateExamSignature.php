<?php

namespace App\Admin\Resources\ExamSignatureResource\Pages;

use App\Admin\Resources\ExamSignatureResource;
use App\Models\ExamSignature;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateExamSignature extends CreateRecord
{
    protected static string $resource = ExamSignatureResource::class;

    protected function handleRecordCreation(array $data): ExamSignature {         
        return DB::transaction(function () use ($data) {             
            $institution = DB::table('institutions')->first(); 
            
          
         
            
            $student = ExamSignature::create([
                'title' => $data['title'],
                'signature' => $data['signature'] ?? 0 ,
                'status' => $data['status'],
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
