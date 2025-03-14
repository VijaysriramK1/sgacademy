<?php

namespace App\Admin\Resources\OnlineAssignProgramResource\Pages;

use App\Admin\Resources\OnlineAssignProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOnlineAssignProgram extends CreateRecord
{
    protected static string $resource = OnlineAssignProgramResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
