<?php

namespace App\Admin\Resources\StudyMaterialResource\Pages;

use App\Admin\Resources\StudyMaterialResource;
use App\Models\StudyMaterial;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateStudyMaterial extends CreateRecord
{
    protected static string $resource = StudyMaterialResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): StudyMaterial
    {
        return DB::transaction(function () use ($data) {

            $availableForAdmin = false;
            $availableForAllPrograms = false;
            if (
                (isset($data['available_for_admin']) && $data['available_for_admin'] === true) &&
                (isset($data['all_classes']) && $data['all_classes'] === true)
            ) {
                $availableForAdmin = true;
                $availableForAllPrograms = true;
            } elseif (
                (isset($data['available_for_student']) && $data['available_for_student'] === true) &&
                (isset($data['all_classes']) && $data['all_classes'] === true)
            ) {
                $availableForAdmin = false;
                $availableForAllPrograms = true;
            } elseif (
                (isset($data['available_for_admin']) && $data['available_for_admin'] === true) &&
                (!isset($data['all_classes']) || $data['all_classes'] === false)
            ) {
                $availableForAdmin = true;
                $availableForAllPrograms = false;
            }

            $uploadFile = $data['upload_file'] ?? null;

            $classId = $availableForAllPrograms ? null : ($data['program_id'] ?? null);
            $sectionId = $availableForAllPrograms ? null : ($data['section_id'] ?? null);

            $studyMaterial = StudyMaterial::create([
                'content_title' => $data['content_title'] ?? null,
                'content_type' => $data['content_type'] ?? null,

                'available_for_admin' => $availableForAdmin ? 1 : 0,
                'available_for_all_programs' => $availableForAllPrograms ? 1 : 0,

                'program_id' => $classId,
                'section_id' => $sectionId,

                'upload_date' => $data['upload_date'] ?? now(),
                'description' => $data['description'] ?? null,
                'source_url' => $data['source_url'] ?? null,
                'upload_file' => $uploadFile,

                'status' => 1
            ]);

            return $studyMaterial;
        });
    }
}
