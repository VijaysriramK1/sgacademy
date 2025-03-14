<?php

namespace App\Admin\Resources\StudentcategoryResource\Pages;

use App\Admin\Resources\StudentcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentcategory extends EditRecord
{
    protected static string $resource = StudentcategoryResource::class;

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
