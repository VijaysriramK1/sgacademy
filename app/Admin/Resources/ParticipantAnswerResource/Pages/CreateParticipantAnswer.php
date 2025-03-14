<?php

namespace App\Admin\Resources\ParticipantAnswerResource\Pages;

use App\Admin\Resources\ParticipantAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateParticipantAnswer extends CreateRecord
{
    protected static string $resource = ParticipantAnswerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
