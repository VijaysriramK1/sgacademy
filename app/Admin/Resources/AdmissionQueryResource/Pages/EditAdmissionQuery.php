<?php

namespace App\Admin\Resources\AdmissionQueryResource\Pages;

use App\Admin\Resources\AdmissionQueryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdmissionQuery extends EditRecord
{
    protected static string $resource = AdmissionQueryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
