<?php

namespace App\Admin\Resources\GradeSetupResource\Pages;

use App\Admin\Resources\GradeSetupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGradeSetup extends EditRecord
{
    protected static string $resource = GradeSetupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
