<?php

namespace App\Admin\Resources\BadgeResource\Pages;

use App\Admin\Resources\BadgeResource;
use App\Models\Badge;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateBadge extends CreateRecord
{
    protected static string $resource = BadgeResource::class;

    protected function handleRecordCreation(array $data): Badge {         
        return DB::transaction(function () use ($data) {             
            $institution = DB::table('institutions')->first(); 
            
          
         
            
            $student = Badge::create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'image' => $data['image'],
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
