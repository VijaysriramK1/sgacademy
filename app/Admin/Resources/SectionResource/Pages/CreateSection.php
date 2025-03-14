<?php

namespace App\Admin\Resources\SectionResource\Pages;

use App\Admin\Resources\SectionResource;
use App\Models\Section;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateSection extends CreateRecord
{
    protected static string $resource = SectionResource::class;

    protected function handleRecordCreation(array $data): Section {         
        return DB::transaction(function () use ($data) {             
            $institution = DB::table('institutions')->first(); 
            
          
         
            
            $student = Section::create([
                
                'name' => $data['name'] ?? null,
               
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
