<?php

namespace App\Admin\Resources\OnlineExamParticipantResource\Pages;

use App\Admin\Resources\OnlineExamParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOnlineExamParticipant extends CreateRecord
{
    protected static string $resource = OnlineExamParticipantResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
