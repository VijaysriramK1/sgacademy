<?php

namespace App\Admin\Resources\StudentgroupResource\Pages;

use App\Admin\Resources\StudentgroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentgroup extends EditRecord
{
    protected static string $resource = StudentgroupResource::class;

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
