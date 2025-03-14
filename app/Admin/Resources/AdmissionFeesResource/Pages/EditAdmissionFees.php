<?php

namespace App\Admin\Resources\AdmissionFeesResource\Pages;

use App\Admin\Resources\AdmissionFeesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdmissionFees extends EditRecord
{
    protected static string $resource = AdmissionFeesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
