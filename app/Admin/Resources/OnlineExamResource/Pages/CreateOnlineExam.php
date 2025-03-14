<?php

namespace App\Admin\Resources\OnlineExamResource\Pages;

use App\Admin\Resources\OnlineExamResource;
use App\Models\OnlineExam;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateOnlineExam extends CreateRecord
{
    protected static string $resource = OnlineExamResource::class;

    
    
    protected function handleRecordCreation(array $data): OnlineExam {         
        return DB::transaction(function () use ($data) {             
            $institution = DB::table('institutions')->first(); 
            $student = OnlineExam::create([
                'title' => $data['title'],
                'date' => $data['date'] ?? 0 ,
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'end_date_time' => $data['end_date_time'],
                'percentage' => $data['percentage'],
                'instruction' => $data['instruction'],
                'is_published' => $data['is_published'],
                'is_taken' => $data['is_taken'],
                'is_closed' => $data['is_closed'],
                'is_waiting' => $data['is_waiting'],
                'is_running' => $data['is_running'],
                'auto_mark' => $data['auto_mark'],
                'status' => $data['status'],
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
