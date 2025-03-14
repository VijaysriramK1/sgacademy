<?php

namespace App\Admin\Resources\LeadIntegrationResource\Pages;

use App\Admin\Resources\LeadIntegrationResource;
use App\Models\LeadIntegration;
use App\Models\SourceType;
use App\Models\Staff;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateLeadIntegration extends CreateRecord
{
    protected static string $resource = LeadIntegrationResource::class;

    protected function handleRecordCreation(array $data): SourceType
    {
        return DB::transaction(function () use ($data) {
            $institution = DB::table('institutions')->first(); 
            
            // Use Eloquent Model instead of DB::table()
            $source = SourceType::create([
                'name' => $data['source'] ?? null,
                'status' => $data['status'] ?? null,
                'description' => $data['description']??null,
                'institution_id' => $institution->id,
            ]);
    
           
    
            return $source; 
        });
    }
    
    
    

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
