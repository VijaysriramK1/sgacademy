<?php

namespace App\Admin\Resources\StudentIdCardResource\Pages;

use App\Admin\Resources\StudentIdCardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentIdCard extends EditRecord
{
    protected static string $resource = StudentIdCardResource::class;

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
