<?php

namespace App\Admin\Resources\ParticipantAnswerResource\Pages;

use App\Admin\Resources\ParticipantAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParticipantAnswer extends EditRecord
{
    protected static string $resource = ParticipantAnswerResource::class;

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
