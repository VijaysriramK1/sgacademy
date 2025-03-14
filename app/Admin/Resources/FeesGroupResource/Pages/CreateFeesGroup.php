<?php

namespace App\Admin\Resources\FeesGroupResource\Pages;

use App\Admin\Resources\FeesGroupResource;
use App\Models\FeesGroup;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateFeesGroup extends CreateRecord
{
    protected static string $resource = FeesGroupResource::class;

    protected function handleRecordCreation(array $data): FeesGroup {         
        return DB::transaction(function () use ($data) {             
            $institution = DB::table('institutions')->first(); 
            
          
         
            
            $student = FeesGroup::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
              
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
