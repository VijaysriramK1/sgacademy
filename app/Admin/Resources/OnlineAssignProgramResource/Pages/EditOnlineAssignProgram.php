<?php

namespace App\Admin\Resources\OnlineAssignProgramResource\Pages;

use App\Admin\Resources\OnlineAssignProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOnlineAssignProgram extends EditRecord
{
    protected static string $resource = OnlineAssignProgramResource::class;

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
