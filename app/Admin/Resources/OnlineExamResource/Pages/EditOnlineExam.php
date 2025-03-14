<?php

namespace App\Admin\Resources\OnlineExamResource\Pages;

use App\Admin\Resources\OnlineExamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOnlineExam extends EditRecord
{
    protected static string $resource = OnlineExamResource::class;

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
