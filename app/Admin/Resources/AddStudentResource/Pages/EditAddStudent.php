<?php

namespace App\Admin\Resources\AddStudentResource\Pages;

use App\Admin\Resources\AddStudentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAddStudent extends EditRecord
{
    protected static string $resource = AddStudentResource::class;

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
