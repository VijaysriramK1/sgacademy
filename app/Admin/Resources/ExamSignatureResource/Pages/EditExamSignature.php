<?php

namespace App\Admin\Resources\ExamSignatureResource\Pages;

use App\Admin\Resources\ExamSignatureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExamSignature extends EditRecord
{
    protected static string $resource = ExamSignatureResource::class;

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
