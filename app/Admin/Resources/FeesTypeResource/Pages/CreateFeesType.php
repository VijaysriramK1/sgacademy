<?php

namespace App\Admin\Resources\FeesTypeResource\Pages;

use App\Admin\Resources\FeesTypeResource;
use App\Models\FeesType;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateFeesType extends CreateRecord
{
    protected static string $resource = FeesTypeResource::class;

    protected function handleRecordCreation(array $data): FeesType
    {
        return DB::transaction(function () use ($data) {
            $institution = DB::table('institutions')->first();




            $student = FeesType::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'fee_group_id' => $data['fee_group_id'] ?? null,
                'type' => $data['type'] ?? null,
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
