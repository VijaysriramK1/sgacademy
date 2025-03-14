<?php

namespace App\Admin\Resources\AdmissionFeesResource\Pages;

use App\Admin\Resources\AdmissionFeesResource;
use App\Models\AdmissionFees;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateAdmissionFees extends CreateRecord
{
    protected static string $resource = AdmissionFeesResource::class;

    protected function handleRecordCreation(array $data): AdmissionFees {         
        return DB::transaction(function () use ($data) {             
            $institution = DB::table('institutions')->first(); 
            
          
         
            
            $student = AdmissionFees::create([
                'fee_type_id' => $data['fee_type_id'],
                'program_id' => $data['program_id'] ?? null,
              
                'batch_id' => $data['batch_id'] ?? null,
                'amount' => $data['amount'] ?? null,
              
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
